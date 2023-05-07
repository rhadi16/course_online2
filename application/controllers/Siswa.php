<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
        $this->load->library('form_validation');

        is_logged_in();
        cek_siswa();
        time_login();
    }

    public function index()
    {
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['siswa'] = $this->db->get_where('siswa', ['id' => $this->session->userdata('id')])->row_array();

        $data['judul'] = "Home";

        $this->load->view('templates/siswa_header', $data);
        $this->load->view('siswa/index');
        $this->load->view('templates/siswa_footer');
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
            $this->load->view('templates/siswa_header', $data);
            $this->load->view('siswa/edit', $data);
            $this->load->view('templates/siswa_footer');
        } else {
            $this->Siswa_model->editProfile($data['profile']['image']);

            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Profile Telah Diubah.</div>');
            redirect('siswa/edit');
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
            $this->load->view('templates/siswa_header', $data);
            $this->load->view('siswa/settingpassword', $data);
            $this->load->view('templates/siswa_footer');
        } else {
            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru1');

            if (!password_verify($password_lama, $data['account']['password'])) {
                $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Password yang Dimasukkan Salah!</div>');
                redirect('siswa/settingpassword');
            } else {
                if ($password_lama == $password_baru) {
                    $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Password yang Baru Tidak Boleh Sama dengan Password Lama!</div>');
                    redirect('siswa/settingpassword');
                } else {
                    // password ok
                    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

                    $this->Siswa_model->settingpassword($password_hash);

                    $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Password Telah Diubah.</div>');
                    redirect('siswa/settingpassword');
                }
            }
        }
    }
    public function jadwal_kelas()
    {
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['siswa'] = $this->db->get_where('siswa', ['id' => $this->session->userdata('id')])->row_array();

        $data['hari'] = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        $data['judul'] = "Jadwal Kelas";

        $this->load->view('templates/siswa_header', $data);
        $this->load->view('siswa/jadwal_kelas');
        $this->load->view('templates/siswa_footer');
    }
    public function download_materi($materi)
    {
        force_download(FCPATH . 'assets/materi/' . $materi, NULL);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Materi Berhasil Didownload.</div>');
        redirect('siswa/jadwal_kelas');
    }
}
