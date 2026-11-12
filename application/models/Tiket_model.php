<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tiket_model extends CI_Model {

    public function by_event($event_id)
    {
        return $this->db->query(
            "SELECT *, (kuota - terjual) AS sisa FROM jenis_tiket WHERE event_id = ? ORDER BY harga",
            array((int)$event_id)
        )->result();
    }
    public function get($id)
    {
        return $this->db->get_where('jenis_tiket', array('id' => (int)$id))->row();
    }
    public function simpan($data, $id = NULL)
    {
        if ($id) {
            $this->db->where('id', $id)->update('jenis_tiket', $data);
        } else {
            $this->db->insert('jenis_tiket', $data);
        }
    }
    public function hapus($id)
    {
        $this->db->where('id', $id)->delete('jenis_tiket');
    }
    public function get_lengkap($id)
    {
        return $this->db->query(
            "SELECT t.*, (t.kuota - t.terjual) AS sisa,
                    e.nama AS event_nama, e.tanggal, e.lokasi, e.status AS event_status
             FROM jenis_tiket t JOIN events e ON e.id = t.event_id
             WHERE t.id = ?", array((int)$id)
        )->row();
    }
}