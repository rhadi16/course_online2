<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');

        is_logged_in();
        cek_admin();
        time_login();
    }

    public function index()
    {
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();

        $data['judul'] = "Home";

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/index');
        $this->load->view('templates/admin_footer');
    }
    // start of manage guru
    public function guru()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['judul'] = "Kelola Guru";

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        $config['base_url'] = base_url() . 'admin/guru';

        $this->db->select('*, profile.id id_guru');
        $this->db->from('profile');
        $this->db->join('role', 'role.id = profile.role_id', 'left');
        $this->db->join('accounts', 'accounts.id = profile.id', 'left');
        $this->db->where('profile.id !=', 1234);
        $this->db->where('profile.role_id =', 2);
        $this->db->like('nama', $data['keyword']);

        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 10;
        $from = $this->uri->segment(3);

        $data['guru'] =  $this->Admin_model->getAllGuru($config['per_page'], $from, $data['keyword']);

        $this->pagination->initialize($config);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/guru', $data);
        $this->load->view('templates/admin_footer');
    }
    public function tambah_guru()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['mapel'] = $this->db->get('ref_mapel')->result_array();
        $data['judul'] = "Kelola Guru";

        $this->form_validation->set_rules('id', 'ID', 'required|is_unique[accounts.id]|trim', array('required' => 'ID Harus Diisi', 'is_unique' => 'ID Telah Digunakan'));
        $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => 'Nama Harus Diisi'));
        $this->form_validation->set_rules('asal', 'Asal', 'required', array('required' => 'Asal Kota Harus Diisi'));
        $this->form_validation->set_rules('tglahir', 'Tanggal Lahir', 'required', array('required' => 'Tanggal Lahir Harus Diisi'));
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[accounts.email]', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar', 'is_unique' => 'Email Telah Digunakan'));
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|matches[password2]', array('required' => 'Password Harus Diisi', 'min_length' => 'Password Harus Lebih 8 Karakter', 'matches' => 'Password Tidak Sama Repeat Password'));
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required', array('required' => 'Repeat Password Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $data['input'] = array(
                'id' => $this->input->post('id'),
                'nama' => $this->input->post('nama'),
                'asal' => $this->input->post('asal'),
                'tglahir' => $this->input->post('tglahir'),
                'email' => $this->input->post('email')
            );

            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/tambah_guru', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Admin_model->tambahGuru();
            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Guru Berhasil Ditambahkan.</div>');
            redirect('admin/guru');
        }
    }
    public function edit_guru($id)
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['mapel'] = $this->db->get('ref_mapel')->result_array();
        $data['judul'] = "Kelola Guru";

        $data['detail'] = $this->Admin_model->detailGuru($id);

        if ($this->input->post('id') == $id) {
            $this->form_validation->set_rules('id', 'ID', 'required|trim', array('required' => 'ID Harus Diisi'));
        } else {
            $this->form_validation->set_rules('id', 'ID', 'required|trim|is_unique[accounts.id]', array('required' => 'ID Harus Diisi', 'is_unique' => 'ID Telah Digunakan'));
        }

        if ($this->input->post('email') == $data['detail']['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar'));
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[accounts.email]', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar', 'is_unique' => 'Email Telah Digunakan'));
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => 'Nama Harus Diisi'));
        $this->form_validation->set_rules('asal', 'Asal', 'required', array('required' => 'Asal Kota Harus Diisi'));
        $this->form_validation->set_rules('tglahir', 'Tanggal Lahir', 'required', array('required' => 'Tanggal Lahir Harus Diisi'));
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|matches[password2]', array('required' => 'Password Harus Diisi', 'min_length' => 'Password Harus Lebih 8 Karakter', 'matches' => 'Password Tidak Sama Repeat Password'));
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim');

        if ($data['detail']) {
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('templates/admin_header', $data);
                $this->load->view('admin/edit_guru', $data);
                $this->load->view('templates/admin_footer');
            } else {
                $this->Admin_model->editGuru();
                $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Data Guru Berhasil Diubah.</div>');
                redirect('admin/guru');
            }
        } else {
            redirect('admin/guru');
        }
    }
    public function hapus_guru($id)
    {
        $this->Admin_model->hapusDataGuru($id);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Data Guru Berhasil Dihapus.</div>');
        redirect('admin/guru');
    }
    // end of manage guru

    // start of manage mata pelajaran
    public function mapel()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['mapel'] =  $this->Admin_model->getAllMapel();

        $data['judul'] = "Kelola Mata Pelajaran";

        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required', array('required' => 'Nama Mata Pelajaran Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/mapel', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Admin_model->tambahMapel();
            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Mata Pelajaran Berhasil Ditambah.</div>');
            redirect('admin/mapel');
        }
    }
    public function editMapel()
    {
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['mapel'] =  $this->Admin_model->getAllMapel();

        $data['judul'] = "Kelola Mata Pelajaran";

        $this->form_validation->set_rules('nama_mapel', 'Nama Mata Pelajaran', 'required', array('required' => 'Nama Mata Pelajaran Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/mapel', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Admin_model->editMapel();
            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Mata Pelajaran Berhasil Diubah.</div>');
            redirect('admin/mapel');
        }
    }
    public function hapusMapel($id)
    {
        $this->Admin_model->hapusMapel($id);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Mata Pelajaran Berhasil Dihapus.</div>');
        redirect('admin/mapel');
    }
    // end of manage mata pelajaran

    // start of manage siswa
    public function siswa()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();

        $data['judul'] = "Kelola Siswa";
        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }
        $config['base_url'] = base_url() . 'admin/siswa';

        $this->db->select('*, profile.id id_siswa');
        $this->db->from('profile');
        $this->db->join('role', 'role.id = profile.role_id', 'left');
        $this->db->join('accounts', 'accounts.id = profile.id', 'left');
        $this->db->where('profile.id !=', 1234);
        $this->db->where('profile.role_id =', 3);
        $this->db->like('nama', $data['keyword']);

        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 10;
        $from = $this->uri->segment(3);

        $data['siswa'] =  $this->Admin_model->getAllSiswa($config['per_page'], $from, $data['keyword']);

        $this->pagination->initialize($config);

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/siswa');
        $this->load->view('templates/admin_footer');
    }
    public function tambah_siswa()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['judul'] = "Kelola Siswa";

        $this->form_validation->set_rules('id', 'ID', 'required|is_unique[accounts.id]|trim', array('required' => 'ID Harus Diisi', 'is_unique' => 'ID Telah Digunakan'));
        $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => 'Nama Harus Diisi'));
        $this->form_validation->set_rules('asal', 'Asal', 'required', array('required' => 'Asal Kota Harus Diisi'));
        $this->form_validation->set_rules('tglahir', 'Tanggal Lahir', 'required', array('required' => 'Tanggal Lahir Harus Diisi'));
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[accounts.email]', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar', 'is_unique' => 'Email Telah Digunakan'));
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|callback_check_kelas');
        $this->form_validation->set_message('check_kelas', 'Kelas Harus Diisi');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|matches[password2]', array('required' => 'Password Harus Diisi', 'min_length' => 'Password Harus Lebih 8 Karakter', 'matches' => 'Password Tidak Sama Repeat Password'));
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required', array('required' => 'Repeat Password Harus Diisi'));

        if ($this->form_validation->run() == FALSE) {
            $data['input'] = array(
                'id' => $this->input->post('id'),
                'nama' => $this->input->post('nama'),
                'asal' => $this->input->post('asal'),
                'tglahir' => $this->input->post('tglahir'),
                'email' => $this->input->post('email')
            );

            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/tambah_siswa', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Admin_model->tambahSiswa();
            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Siswa Berhasil Ditambahkan.</div>');
            redirect('admin/siswa');
        }
    }
    function check_kelas($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    public function edit_siswa($id)
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['judul'] = "Kelola Guru";

        $data['detail'] = $this->Admin_model->detailSiswa($id);
        $data['kelas_detail'] = $this->Admin_model->kelasSiswa($data['detail']['id_siswa']);

        if ($this->input->post('id') == $id) {
            $this->form_validation->set_rules('id', 'ID', 'required|trim', array('required' => 'ID Harus Diisi'));
        } else {
            $this->form_validation->set_rules('id', 'ID', 'required|trim|is_unique[accounts.id]', array('required' => 'ID Harus Diisi', 'is_unique' => 'ID Telah Digunakan'));
        }

        if ($this->input->post('email') == $data['detail']['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar'));
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[accounts.email]', array('required' => 'Email Harus Diisi', 'valid_email' => 'Isi Email Denga Format yang Benar', 'is_unique' => 'Email Telah Digunakan'));
        }
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|callback_check_kelas_edit');
        $this->form_validation->set_message('check_kelas_edit', 'Kelas Harus Diisi');

        $this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => 'Nama Harus Diisi'));
        $this->form_validation->set_rules('asal', 'Asal', 'required', array('required' => 'Asal Kota Harus Diisi'));
        $this->form_validation->set_rules('tglahir', 'Tanggal Lahir', 'required', array('required' => 'Tanggal Lahir Harus Diisi'));
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|matches[password2]', array('required' => 'Password Harus Diisi', 'min_length' => 'Password Harus Lebih 8 Karakter', 'matches' => 'Password Tidak Sama Repeat Password'));
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim');

        if ($data['detail']) {
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('templates/admin_header', $data);
                $this->load->view('admin/edit_siswa', $data);
                $this->load->view('templates/admin_footer');
            } else {
                $this->Admin_model->editSiswa();
                $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Data Siswa Berhasil Diubah.</div>');
                redirect('admin/siswa');
            }
        } else {
            redirect('admin/siswa');
        }
    }
    function check_kelas_edit($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    public function hapus_siswa($id)
    {
        $this->Admin_model->hapusDataSiswa($id);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Data Siswa Berhasil Dihapus.</div>');
        redirect('admin/siswa');
    }
    // end of manage siswa

    // start of manage class
    public function jadwal_kelas()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['mapel'] = $this->db->get('ref_mapel')->result_array();

        $data['judul'] = "Kelola Jadwal Kelas";

        if ($this->input->post('submit')) {
            $data['keyword'] = $this->input->post('keyword');
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = $this->session->userdata('keyword');
        }

        $data['kelases'] =  $this->Admin_model->getKelas();
        $data['kelas'] =  $this->Admin_model->getDetailKelas($data['keyword']);

        $this->form_validation->set_rules('nama_kls', 'Nama Kelas', 'required', array('required' => 'Nama Kelas Harus Diisi'));
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|callback_check_mapel');
        $this->form_validation->set_message('check_mapel', 'Mata Pelajaran Harus Diisi');
        $this->form_validation->set_rules('hari', 'Hari', 'required|callback_check_hari');
        $this->form_validation->set_message('check_hari', 'Hari Harus Diisi');
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required', array('required' => 'Jam Masuk Harus Diisi'));
        $this->form_validation->set_rules('jam_keluar', 'Jam Keluar', 'required', array('required' => 'Jam Keluar Harus Diisi'));
        $this->form_validation->set_rules('id_guru', 'Guru', 'required|callback_check_guru');
        $this->form_validation->set_message('check_guru', 'Guru Harus Diisi');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/jadwal_kelas', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Admin_model->tambahJadwal();
        }
    }
    public function tambah_kelas()
    {
        $data['csrf'] = csrf();
        $data['account'] = $this->db->get_where('accounts', ['email' => $this->session->userdata('email')])->row_array();
        $data['profile'] = $this->db->get_where('profile', ['id' => $this->session->userdata('id')])->row_array();
        $data['mapel'] = $this->db->get('ref_mapel')->result_array();

        $data['judul'] = "Kelola Jadwal Kelas";

        $this->form_validation->set_rules('nama_kls', 'Nama Kelas', 'required|is_unique[jadwal.nama_kls]', array('required' => 'Nama Kelas Harus Diisi', 'is_unique' => 'Nama Kelas Sudah Ada'));
        $this->form_validation->set_rules('id_mapel', 'Mapel', 'required|callback_check_mapel');
        $this->form_validation->set_message('check_mapel', 'Mata Pelajaran Harus Diisi');
        $this->form_validation->set_rules('hari', 'Hari', 'required|callback_check_hari');
        $this->form_validation->set_message('check_hari', 'Hari Harus Diisi');
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'required', array('required' => 'Jam Masuk Harus Diisi'));
        $this->form_validation->set_rules('jam_keluar', 'Jam Keluar', 'required', array('required' => 'Jam Keluar Harus Diisi'));
        $this->form_validation->set_rules('id_guru', 'Guru', 'required|callback_check_guru');
        $this->form_validation->set_message('check_guru', 'Guru Harus Diisi');

        if ($this->form_validation->run() == FALSE) {
            $data['input'] = array(
                'nama_kls' => $this->input->post('nama_kls'),
                'hari' => $this->input->post('hari'),
                'jam_masuk' => $this->input->post('jam_masuk'),
                'jam_keluar' => $this->input->post('jam_keluar')
            );

            $this->load->view('templates/admin_header', $data);
            $this->load->view('admin/tambah_kelas', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $this->Admin_model->tambahKelas();
        }
    }
    function check_hari($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    function check_mapel($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    function check_guru($post_string)
    {
        return $post_string == '0' ? FALSE : TRUE;
    }
    public function guruDetail()
    {
        $postData = $this->input->post('mapel');
        $data['data'] = $this->Admin_model->guruDetail($postData);
        $data['valC'] = $this->security->get_csrf_hash();

        echo json_encode($data);
    }
    public function hapus_jadwal($id)
    {
        $this->Admin_model->hapusDataJadwal($id);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Jadwal Berhasil Dihapus.</div>');
        redirect('admin/jadwal_kelas');
    }
    public function hapus_kelas($nama_kls)
    {
        $this->Admin_model->hapusDataKelas($nama_kls);
        $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Kelas Berhasil Dihapus.</div>');
        redirect('admin/jadwal_kelas');
    }
}
