<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        need_role('admin');
        $this->load->model('Event_model');
        $this->load->model('Tiket_model');
        $this->load->model('Pesanan_model');
        $this->load->model('User_model');
    }
    private function page($view, $data = array())
    {
        $this->load->view('layout/admin_header', $data);
        $this->load->view('admin/' . $view, $data);
        $this->load->view('layout/admin_footer');
    }
    public function index()
    {
        $this->page('dashboard', array(
            'title' => 'Dashboard',
            'r'     => $this->Pesanan_model->ringkasan(),
        ));
    }
    public function pemesan()
    {
        $q = trim((string)$this->input->get('q'));
        $this->page('pemesan', array(
            'title'   => 'Data Pemesan',
            'pemesan' => $this->User_model->pemesan($q),
            'q'       => $q,
        ));
    }
    public function laporan()
    {
        $this->page('laporan', array(
            'title' => 'Laporan Tiket',
            'rekap' => $this->Pesanan_model->rekap(),
        ));
    }
    public function events()
    {
        $q = trim((string)$this->input->get('q'));
        $this->page('events', array(
            'title'  => 'Kelola Event',
            'events' => $this->Event_model->semua($q),
            'q'      => $q,
        ));
    }
    public function event_form($id = NULL)
    {
        $event = $id ? $this->Event_model->get($id) : NULL;
        if ($id && !$event) show_404();

        $this->form_validation->set_rules('nama', 'Nama event', 'required|max_length[150]');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|integer');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|max_length[150]');
        $this->form_validation->set_rules('tanggal', 'Tanggal event', 'required|callback__cek_tanggal');

        if ($this->form_validation->run()) {
            $this->Event_model->simpan(array(
                'nama'        => $this->input->post('nama', TRUE),
                'kategori_id' => (int)$this->input->post('kategori_id'),
                'deskripsi'   => $this->input->post('deskripsi', TRUE),
                'lokasi'      => $this->input->post('lokasi', TRUE),
                'tanggal'     => str_replace('T', ' ', $this->input->post('tanggal')) . ':00',
                'status'      => $this->input->post('status') === 'selesai' ? 'selesai' : 'aktif',
            ), $id);
            $this->session->set_flashdata('success', 'Data event berhasil disimpan.');
            redirect('admin/events');
        }

        $this->page('event_form', array(
            'title'    => $id ? 'Edit Event' : 'Tambah Event',
            'event'    => $event,
            'kategori' => $this->Event_model->kategori(),
        ));
    }
    public function _cek_tanggal($v)
    {
        $d = DateTime::createFromFormat('Y-m-d\TH:i', $v);
        if (!$d || $d->format('Y-m-d\TH:i') !== $v) {
            $this->form_validation->set_message('_cek_tanggal', 'Tanggal event tidak valid.');
            return FALSE;
        }
        return TRUE;
    }
    public function event_hapus($id)
    {
        $this->Event_model->hapus($id);
        $this->session->set_flashdata('success', 'Event dihapus.');
        redirect('admin/events');
    }
    public function tiket()
    {
        $events = $this->Event_model->semua();
        foreach ($events as $e) {
            $e->tiket = $this->Tiket_model->by_event($e->id);
        }
        $this->page('tiket', array('title' => 'Jenis Tiket', 'events' => $events));
    }

    public function tiket_form($event_id, $id = NULL)
    {
        $event = $this->Event_model->get($event_id);
        if (!$event) show_404();

        $tiket = $id ? $this->Tiket_model->get($id) : NULL;
        $terjual = $tiket ? (int)$tiket->terjual : 0;
        $this->form_validation->set_rules('nama', 'Nama tiket', 'required|max_length[50]');
        $this->form_validation->set_rules('harga', 'Harga', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('kuota', 'Kuota', 'required|integer|greater_than[0]');

        if ($this->form_validation->run()) {
            $kuota = (int)$this->input->post('kuota');

            if ($kuota < $terjual) {
                $this->session->set_flashdata('error', "Kuota tidak boleh lebih kecil dari tiket yang sudah terjual ($terjual).");
                redirect(current_url());
            }

            $this->Tiket_model->simpan(array(
                'event_id' => $event_id,
                'nama'     => $this->input->post('nama', TRUE),
                'harga'    => (int)$this->input->post('harga'),
                'kuota'    => $kuota,
            ), $id);

            $this->session->set_flashdata('success', 'Jenis tiket disimpan.');
            redirect('admin/tiket');
        }

        $this->page('tiket_form', array(
            'title' => $id ? 'Edit Tiket (Ubah Kuota)' : 'Tambah Jenis Tiket',
            'event' => $event,
            'tiket' => $tiket,
        ));
    }
    public function tiket_hapus($id)
    {
        $this->Tiket_model->hapus($id);
        $this->session->set_flashdata('success', 'Jenis tiket dihapus.');
        redirect('admin/tiket');
    }
    public function transaksi()
    {
        $this->Pesanan_model->kadaluarsa();  

        $q  = trim((string)$this->input->get('q'));
        $st = (string)$this->input->get('status');

        $this->page('transaksi', array(
            'title'   => 'Transaksi Pemesanan',
            'pesanan' => $this->Pesanan_model->cari($q, $st),
            'q'       => $q,
            'st'      => $st,
        ));
    }
    public function verifikasi($id)
    {
        if ($this->Pesanan_model->verifikasi($id)) {
            $this->session->set_flashdata('success', 'Pembayaran diverifikasi. Pesanan berhasil.');
        } else {
            $this->session->set_flashdata('error', 'Pesanan tidak bisa diverifikasi (status bukan Menunggu Verifikasi).');
        }
        redirect('admin/transaksi');
    }
    public function batalkan($id)
    {
        if ($this->Pesanan_model->batalkan($id)) {
            $this->session->set_flashdata('success', 'Pesanan dibatalkan dan kuota dikembalikan.');
        } else {
            $this->session->set_flashdata('error', 'Pesanan tidak bisa dibatalkan.');
        }
        redirect('admin/transaksi');
    }
}