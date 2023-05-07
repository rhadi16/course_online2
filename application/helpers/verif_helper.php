<?php

function is_logged_in()
{
    $ci = get_instance();
    $data['account'] = $ci->db->get_where('accounts', ['email' => $ci->session->userdata('email')])->row_array();

    if (!$ci->session->userdata('email')) {
        redirect('auth');
    }

    if (!$data['account']) {
        redirect('auth/logout');
    }
}
function cek_admin()
{
    $ci = get_instance();
    if ($ci->session->userdata('role_id') != 1) {
        redirect('guru');
    }
}
function cek_guru()
{
    $ci = get_instance();
    if ($ci->session->userdata('role_id') != 2) {
        redirect('siswa');
    }
}
function cek_siswa()
{
    $ci = get_instance();
    if ($ci->session->userdata('role_id') != 3) {
        redirect('auth');
    }
}
function is_logged_out()
{
    $ci = get_instance();
    if ($ci->session->userdata('id')) {
        redirect('admin');
    } else {
        if (get_cookie('remember_me')) {
            $cook = get_cookie('remember_me');
            $h = $ci->encryption->decrypt($cook);

            $account = $ci->db->get_where('accounts', ['id' => $h])->row_array();
            $profile = $ci->db->get_where('profile', ['id' => $h])->row_array();

            if ($account && $profile) {
                $data = array(
                    'id' => $profile['id'],
                    'email' => $account['email'],
                    'role_id' => $profile['role_id'],
                    'expired' => time() + 900
                );

                $ci->session->set_userdata($data);
                if ($profile['role_id'] == 1) {
                    redirect('admin');
                } elseif ($profile['role_id'] == 2) {
                    redirect('guru');
                } elseif ($profile['role_id'] == 3) {
                    redirect('siswa');
                } else {
                    redirect('auth');
                }
            }
        }
    }
}
function time_login()
{
    $ci = get_instance();

    if (time() > $ci->session->userdata('expired')) {
        redirect('auth/logout');
    } else {
        $ci->session->set_userdata('expired', time() + 900);
    }
}
function csrf()
{
    $ci = get_instance();

    return $csrf = array(
        'name' => $ci->security->get_csrf_token_name(),
        'hash' => $ci->security->get_csrf_hash()
    );
}
