<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Guru_model');
        $this->load->model('Admin_model');
        $this->load->library('form_validation');

        is_logged_in();
        cek_guru();
        time_login();
    }

    public function index()
    {
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();

        $data['judul'] = "Home";

        $this->load->view('templates/guru_header', $data);
        $this->load->view('guru/index');
        $this->load->view('templates/guru_footer');
    }
    public function edit()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();

        $data['judul'] = "My Profile";

        if ($this->input->post('email') == $data['account']['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar'));
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[accounts.email]', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar', 'is_unique' => 'Email Telah Digunakan'));
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', array('required' => 'Nama Harus Diisi'));
        $this->form_validation->set_rules('asal', 'Asal Kota', 'required|trim', array('required' => 'Asal Kota Harus Diisi'));
        $this->form_validation->set_rules('tglahir', 'Tanggal Lahir', 'required|trim', array('required' => 'Tanggal Lahir Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/guru_header', $data);
            $this->load->view('guru/edit', $data);
            $this->load->view('templates/guru_footer');
        } else {
            $this->Guru_model->editProfile($data['profile']['image']);

            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Profile Telah Diubah.</div>');
            redirect('guru/edit');
        }
    }
    public function settingpassword()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();

        $data['judul'] = "Setting Password";

        $this->form_validation->set_rules('password_lama', 'Password Sekarang', 'required|trim', array('required' => 'Password Harus Diisi'));
        $this->form_validation->set_rules('password_baru1', 'Password Baru', 'required|trim|min_length[8]|matches[password_baru2]', array('required' => 'Password Harus Diisi', 'min_length' => 'Panjang Password Harus Lebih 8 Karakter', 'matches' => 'Password Baru Tidak Sama Repeat Password'));
        $this->form_validation->set_rules('password_baru2', 'Repeat Password Baru', 'required|trim', array('required' => 'Repeat Password Baru Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/guru_header', $data);
            $this->load->view('guru/settingpassword', $data);
            $this->load->view('templates/guru_footer');
        } else {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru1');

            if (!password_verify($password_lama, $data['account']['password'])) {
                $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Password yang Dimasukkan Salah!</div>');
                redirect('guru/settingpassword');
            } else {
                if ($password_lama == $password_baru) {
                    $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Password yang Baru Tidak Boleh Sama dengan Password Lama!</div>');
                    redirect('guru/settingpassword');
                } else {
                    // password ok
                    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

                    $this->Guru_model->settingpassword($password_hash);

                    $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Password Telah Diubah.</div>');
                    redirect('guru/settingpassword');
                }
            }
        }
    }
    public function kelola_kelas()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();

        $data['kGuru'] = $this->Admin_model->kelasGuru($data['account']['id']);

        $data['judul'] = "Kelola Kelas";

        $this->form_validation->set_rules('link_kls', 'Link Kelas', 'required|trim', array('required' => 'Link Kelas Harus Diisi'));
        $this->form_validation->set_rules('link_meet', 'Link Meet', 'required|trim', array('required' => 'Link Meet Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/guru_header', $data);
            $this->load->view('guru/kelola_kelas', $data);
            $this->load->view('templates/guru_footer');
        } else {
            $this->Guru_model->editJadwal();

            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Jadwal Telah Diubah.</div>');
            redirect('guru/kelola_kelas');
        }
    }
    public function download_materi($materi)
    {
        force_download(FCPATH . 'assets/materi/' . $materi, NULL);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Materi Berhasil Diubah.</div>');
        redirect('guru/kelola_kelas');
    }
    public function hapus_materi($materi)
    {
        $this->Guru_model->hapusMateri($materi);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Materi Berhasil Dihapus.</div>');
        redirect('guru/kelola_kelas');
    }
}
