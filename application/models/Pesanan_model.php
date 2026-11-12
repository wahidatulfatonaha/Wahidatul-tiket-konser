<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan_model extends CI_Model {


    public function buat($user_id, $tiket_id, $jumlah, $nama, $email, $telepon, $metode, $bukti = NULL)
    {
        $this->db->trans_begin();

        $t = $this->db->query(
            "SELECT t.*, e.tanggal, e.status AS event_status
             FROM jenis_tiket t JOIN events e ON e.id = t.event_id
             WHERE t.id = ? FOR UPDATE", array((int)$tiket_id)
        )->row();

        if (!$t) {
            $this->db->trans_rollback();
            return array(FALSE, 'Jenis tiket tidak ditemukan.', NULL);
        }

        if ($t->event_status === 'selesai' || strtotime($t->tanggal) < time()) {
            $this->db->trans_rollback();
            return array(FALSE, 'Event sudah selesai, pemesanan tidak dapat dilakukan.', NULL);
        }

        $sisa = (int)$t->kuota - (int)$t->terjual;
        if ($jumlah > $sisa) {
            $this->db->trans_rollback();
            return array(FALSE, 'Jumlah tiket melebihi kuota. Sisa tiket ' . $t->nama . ' tinggal ' . $sisa . '.', NULL);
        }

        $total = (int)$t->harga * (int)$jumlah;

        $kode      = 'TKT-' . date('ymd') . '-' . strtoupper(substr(md5(uniqid('', TRUE)), 0, 6));
        $kode_bayar = '88' . sprintf('%010d', mt_rand(0, 999999999));
        $batas     = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $this->db->insert('pemesanan', array(
            'kode'         => $kode,
            'user_id'      => $user_id,
            'tiket_id'     => $tiket_id,
            'nama_pemesan' => $nama,
            'email'        => $email,
            'telepon'      => $telepon,
            'jumlah'       => $jumlah,
            'total'        => $total,
            'metode_bayar' => $metode,
            'bukti_bayar'  => $bukti,
            'kode_bayar'   => $kode_bayar,
            'batas_bayar'  => $batas,
            'status'       => $bukti ? 'Menunggu Verifikasi' : 'Menunggu Pembayaran',
        ));

        $this->db->query("UPDATE jenis_tiket SET terjual = terjual + ? WHERE id = ?",
            array((int)$jumlah, (int)$tiket_id));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(FALSE, 'Terjadi kesalahan saat menyimpan pesanan.', NULL);
        }

        $this->db->trans_commit();
        return array(TRUE, 'Pesanan berhasil dibuat.', $kode);
    }
    public function milik($user_id)
    {
        return $this->db->query(
            "SELECT p.*, t.nama AS tiket, e.nama AS event, e.tanggal
             FROM pemesanan p
             JOIN jenis_tiket t ON t.id = p.tiket_id
             JOIN events e ON e.id = t.event_id
             WHERE p.user_id = ? ORDER BY p.created_at DESC", array((int)$user_id)
        )->result();
    }
    public function by_kode($kode, $user_id)
    {
        return $this->db->get_where('pemesanan', array(
            'kode'    => $kode,
            'user_id' => (int)$user_id,
        ))->row();
    }
    public function simpan_bukti($id, $file)
    {
        $this->db->where('id', (int)$id)->update('pemesanan', array(
            'bukti_bayar' => $file,
            'status'      => 'Menunggu Verifikasi',
        ));
    }
    public function cari($q = '', $status = '')
    {
        $sql = "SELECT p.*, t.nama AS tiket, t.harga, e.nama AS event
                FROM pemesanan p
                JOIN jenis_tiket t ON t.id = p.tiket_id
                JOIN events e ON e.id = t.event_id
                WHERE 1=1";
        $bind = array();
        if ($q !== '') {
            $sql .= " AND (p.kode LIKE ? OR p.nama_pemesan LIKE ? OR e.nama LIKE ?)";
            array_push($bind, "%$q%", "%$q%", "%$q%");
        }
        if ($status !== '') {
            $sql .= " AND p.status = ?";
            $bind[] = $status;
        }
        $sql .= " ORDER BY p.created_at DESC";
        return $this->db->query($sql, $bind)->result();
    }
    public function verifikasi($id)
    {
        $this->db->where('id', (int)$id)
                 ->where('status', 'Menunggu Verifikasi')
                 ->update('pemesanan', array('status' => 'Berhasil'));
        return $this->db->affected_rows() > 0;
    }
    public function batalkan($id)
    {
        $this->db->trans_begin();

        $p = $this->db->query("SELECT * FROM pemesanan WHERE id = ? FOR UPDATE", array((int)$id))->row();
        if (!$p || $p->status === 'Dibatalkan') {
            $this->db->trans_rollback();
            return FALSE;
        }

        $this->db->where('id', $p->id)->update('pemesanan', array('status' => 'Dibatalkan'));
        $this->db->query("UPDATE jenis_tiket SET terjual = GREATEST(terjual - ?, 0) WHERE id = ?",
            array((int)$p->jumlah, (int)$p->tiket_id));

        $this->db->trans_commit();
        return TRUE;
    }
    public function kadaluarsa()
    {
        $rows = $this->db->query(
            "SELECT id FROM pemesanan WHERE status = 'Menunggu Pembayaran' AND batas_bayar < NOW()"
        )->result();
        foreach ($rows as $r) {
            $this->batalkan($r->id);
        }
    }
    public function ringkasan()
    {
        return $this->db->query("SELECT
            (SELECT COUNT(*) FROM events) AS jml_event,
            (SELECT COUNT(*) FROM users WHERE role = 'pelanggan') AS jml_pelanggan,
            (SELECT COUNT(*) FROM pemesanan WHERE status = 'Menunggu Verifikasi') AS perlu_verifikasi,
            (SELECT COALESCE(SUM(jumlah), 0) FROM pemesanan WHERE status = 'Berhasil') AS tiket_terjual,
            (SELECT COALESCE(SUM(total), 0) FROM pemesanan WHERE status = 'Berhasil') AS pendapatan
        ")->row();
    }
    public function rekap()
    {
        return $this->db->query("SELECT e.nama AS event, e.tanggal, t.nama AS tiket, t.harga,
                t.kuota, t.terjual, (t.kuota - t.terjual) AS sisa,
                (SELECT COALESCE(SUM(p.total), 0) FROM pemesanan p
                  WHERE p.tiket_id = t.id AND p.status = 'Berhasil') AS pendapatan
            FROM jenis_tiket t
            JOIN events e ON e.id = t.event_id
            ORDER BY e.tanggal, t.harga
        ")->result();
    }
}