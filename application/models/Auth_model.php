<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_model
{
    public function login()
    {
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        $account = $this->db->get_where('accounts', ['email' => $email])->row_array();
        $profile = $this->db->get_where('profile', ['id' => $account['id']])->row_array();

        if ($account) {
            if ($account['is_active'] == 1) {
                if (password_verify($password, $account['password'])) {
                    $data = array(
                        'id' => $account['id'],
                        'email' => $account['email'],
                        'role_id' => $profile['role_id'],
                        'expired' => time() + 900
                    );
                    $this->session->set_userdata($data);

                    if ($this->input->post('remember', true) == 1) {
                        $dt_cookie = $this->encryption->encrypt($account['id']);
                        $cookie = array(
                            'name'   => 'remember_me',
                            'value'  => $dt_cookie,
                            'expire' => '900',
                            'secure' => TRUE
                        );

                        set_cookie($cookie);
                    }

                    if ($profile['role_id'] == 1) {
                        redirect('admin');
                    } elseif ($profile['role_id'] == 2) {
                        redirect('guru');
                    } elseif ($profile['role_id'] == 3) {
                        redirect('siswa');
                    } else {
                        $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Role Anda Tidak Jelas!</div>');
                        redirect('auth');
                    }
                } else {
                    $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Password yang Anda Masukkan Salah!</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Akun Belum Diaktifkan. Silahkan Aktifkan Melalui Email Anda!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Akun Belum Terdaftar!</div>');
            redirect('auth');
        }
    }
}
