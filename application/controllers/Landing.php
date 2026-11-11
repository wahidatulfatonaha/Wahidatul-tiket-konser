<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function index()
    {
        $this->load->model('Event_model');

        $data['title']  = 'Tiket Konser';
        $data['events'] = $this->Event_model->daftar_aktif();

        $this->load->view('layout/header', $data);
        $this->load->view('landing/index', $data);
        $this->load->view('layout/footer');
    }
    public function detail($id)
    {
        $this->load->model('Event_model');
        $this->load->model('Tiket_model');

        $event = $this->Event_model->get($id);
        if (!$event) show_404();

        $data['title']   = $event->nama . ' - Tiket Konser';
        $data['event']   = $event;
        $data['tiket']   = $this->Tiket_model->by_event($id);
        $data['selesai'] = ($event->status === 'selesai' || strtotime($event->tanggal) < time());

        $this->load->view('layout/header', $data);
        $this->load->view('landing/detail', $data);
        $this->load->view('layout/footer');
    }
}