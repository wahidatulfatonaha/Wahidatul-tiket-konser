<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        need_role('pelanggan');
        $this->load->model('Event_model');
        $this->load->model('Tiket_model');
        $this->load->model('Pesanan_model');
    }

    public function index()
    {
        $data['title']  = 'Dashboard';
        $data['events'] = $this->Event_model->daftar_aktif();

        $this->load->view('layout/header', $data);
        $this->load->view('pelanggan/dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function pesanan()
    {
        $u = user_login();
        $data['title']   = 'Pesanan Saya';
        $data['pesanan'] = $this->Pesanan_model->milik($u['id']);

        $this->load->view('layout/header', $data);
        $this->load->view('pelanggan/pesanan', $data);
        $this->load->view('layout/footer');
    }

    public function pesan($tiket_id)
    {
        $u     = user_login();
        $tiket = $this->Tiket_model->get_lengkap($tiket_id);
        if (!$tiket) show_404();

        $selesai = ($tiket->event_status === 'selesai' || strtotime($tiket->tanggal) < time());

        $this->form_validation->set_rules('nama_pemesan', 'Nama pemesan', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('telepon', 'No. Telepon', 'required|numeric|min_length[9]|max_length[15]');
        $this->form_validation->set_rules('jumlah', 'Jumlah tiket', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('metode', 'Metode pembayaran', 'required|in_list[' . implode(',', array_keys(info_bayar())) . ']');

        if ($this->form_validation->run()) {

            if ($selesai) {
                $this->session->set_flashdata('error', 'Event sudah selesai, pemesanan tidak dapat dilakukan.');
                redirect('event/' . $tiket->event_id);
            }

            $bukti = NULL;
            if (!empty($_FILES['bukti']['name'])) {
                $this->load->library('upload', array(
                    'upload_path'   => FCPATH . 'uploads/bukti/',
                    'allowed_types' => 'jpg|jpeg|png|pdf',
                    'max_size'      => 2048,
                    'encrypt_name'  => TRUE,
                ));
                if ($this->upload->do_upload('bukti')) {
                    $bukti = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
                    redirect('pesan/' . $tiket_id);
                }
            }

            list($ok, $pesan, $kode) = $this->Pesanan_model->buat(
                $u['id'], $tiket_id, (int)$this->input->post('jumlah'),
                $this->input->post('nama_pemesan', TRUE),
                $this->input->post('email', TRUE),
                $this->input->post('telepon', TRUE),
                $this->input->post('metode'),
                $bukti
            );

            if ($ok) {
                $this->session->set_flashdata('success', 'Pesanan dibuat dengan kode ' . $kode . '.');
                redirect('pelanggan/pesanan');
            }

            if ($bukti) @unlink(FCPATH . 'uploads/bukti/' . $bukti);
            $this->session->set_flashdata('error', $pesan);
            redirect('pesan/' . $tiket_id);
        }

        $data = array('title' => 'Pesan Tiket', 'tiket' => $tiket, 'selesai' => $selesai, 'u' => $u);
        $this->load->view('layout/header', $data);
        $this->load->view('pelanggan/pesan', $data);
        $this->load->view('layout/footer');
    }

    public function upload_bukti($kode)
    {
        $u = user_login();
        $p = $this->Pesanan_model->by_kode($kode, $u['id']);
        if (!$p) show_404(); 

        if ($p->status !== 'Menunggu Pembayaran') {
            $this->session->set_flashdata('error', 'Pesanan ini tidak bisa menerima bukti pembayaran lagi.');
            redirect('pelanggan/pesanan');
        }

        if (empty($_FILES['bukti']['name'])) {
            $this->session->set_flashdata('error', 'Pilih file bukti pembayaran dulu.');
            redirect('pelanggan/pesanan');
        }

        $this->load->library('upload', array(
            'upload_path'   => FCPATH . 'uploads/bukti/',
            'allowed_types' => 'jpg|jpeg|png|pdf',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE,
        ));

        if ($this->upload->do_upload('bukti')) {
            $this->Pesanan_model->simpan_bukti($p->id, $this->upload->data('file_name'));
            $this->session->set_flashdata('success', 'Bukti pembayaran terkirim. Menunggu verifikasi admin.');
        } else {
            $this->session->set_flashdata('error', strip_tags($this->upload->display_errors()));
        }
        redirect('pelanggan/pesanan');
    }
}