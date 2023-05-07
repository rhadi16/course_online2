<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        is_logged_out();
        $data['csrf'] = csrf();
        $data['judul'] = "Login";

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email dengan Format yang Benar'));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]', array('required' => 'Password Harus Diisi', 'min_length' => 'Password Harus Lebih dari 8 Karakter'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->Auth_model->login();
        }
    }
    public function logout()
    {
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('expired');
        delete_cookie('remember_me');

        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Anda Telah Logout.</div>');
        redirect('auth');
    }
}
