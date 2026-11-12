<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends CI_Model {

    public function daftar_aktif()
    {
        $sql = "SELECT e.*, k.nama AS kategori,
                (SELECT MIN(harga) FROM jenis_tiket WHERE event_id = e.id) AS harga_min,
                (SELECT COALESCE(SUM(kuota - terjual),0) FROM jenis_tiket WHERE event_id = e.id) AS sisa
                FROM events e
                JOIN kategori k ON k.id = e.kategori_id
                WHERE e.status = 'aktif' AND e.tanggal >= NOW()
                ORDER BY e.tanggal ASC";
        return $this->db->query($sql)->result();
    }
    public function semua($q = '')
    {
        $sql = "SELECT e.*, k.nama AS kategori,
                (SELECT COALESCE(SUM(kuota - terjual),0) FROM jenis_tiket WHERE event_id = e.id) AS sisa
                FROM events e JOIN kategori k ON k.id = e.kategori_id WHERE 1=1";
        $bind = array();
        if ($q !== '') {
            $sql .= " AND (e.nama LIKE ? OR e.lokasi LIKE ?)";
            $bind = array("%$q%", "%$q%");
        }
        $sql .= " ORDER BY e.tanggal DESC";
        return $this->db->query($sql, $bind)->result();
    }
    public function get($id)
    {
        return $this->db->get_where('events', array('id' => (int)$id))->row();
    }
    public function simpan($data, $id = NULL)
    {
        if ($id) {
            $this->db->where('id', $id)->update('events', $data);
        } else {
            $this->db->insert('events', $data);
        }
    }
    public function hapus($id)
    {
        $this->db->where('id', $id)->delete('events');
    }
    public function kategori()
    {
        return $this->db->order_by('nama')->get('kategori')->result();
    }
}