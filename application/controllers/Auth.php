<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        if ($u = user_login()) {
            redirect($u['role'] === 'admin' ? 'admin' : 'pelanggan');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $user = $this->User_model->by_email($this->input->post('email', TRUE));

            if ($user && password_verify($this->input->post('password'), $user->password)) {
                $this->session->set_userdata('user', array(
                    'id'      => $user->id,
                    'nama'    => $user->nama,
                    'email'   => $user->email,
                    'telepon' => $user->telepon,
                    'role'    => $user->role
                ));
                redirect($user->role === 'admin' ? 'admin' : 'pelanggan');
            }

            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('login');
        }

        $data['title'] = 'Masuk - Tiket Konser';
        $this->load->view('layout/header', $data);
        $this->load->view('auth/login');
        $this->load->view('layout/footer');
    }

    public function register()
    {
        if (user_login()) redirect('pelanggan');

        $this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]',
            array('is_unique' => 'Email sudah terdaftar.'));
        $this->form_validation->set_rules('telepon', 'No. Telepon', 'required|numeric|min_length[9]|max_length[15]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('konfirmasi', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run()) {
            $this->User_model->daftar(array(
                'nama'     => $this->input->post('nama', TRUE),
                'email'    => $this->input->post('email', TRUE),
                'telepon'  => $this->input->post('telepon', TRUE),
                'password' => $this->input->post('password'),
            ));
            $this->session->set_flashdata('success', 'Pendaftaran berhasil, silakan login.');
            redirect('login');
        }

        $data['title'] = 'Daftar - Tiket Konser';
        $this->load->view('layout/header', $data);
        $this->load->view('auth/register');
        $this->load->view('layout/footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        redirect('');
    }
}