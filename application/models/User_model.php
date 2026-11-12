<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function by_email($email)
    {
        return $this->db->get_where('users', array('email' => $email))->row();
    }
    public function daftar($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role'] = 'pelanggan';
        $this->db->insert('users', $data);
    }
    public function pemesan($q = '')
    {
        $sql = "SELECT u.*, COUNT(p.id) AS jml_transaksi,
                COALESCE(SUM(CASE WHEN p.status = 'Berhasil' THEN p.total END), 0) AS total_belanja
                FROM users u
                LEFT JOIN pemesanan p ON p.user_id = u.id
                WHERE u.role = 'pelanggan'";
        $bind = array();
        if ($q !== '') {
            $sql .= " AND (u.nama LIKE ? OR u.email LIKE ?)";
            $bind = array("%$q%", "%$q%");
        }
        $sql .= " GROUP BY u.id ORDER BY u.nama";
        return $this->db->query($sql, $bind)->result();
    }
}