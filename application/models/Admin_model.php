<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_model
{
    // start of Guru Models
    public function getAllGuru($number, $offset, $keyword = null)
    {
        $this->db->select('*, profile.id id_guru');
        $this->db->where('profile.id !=', 1234);
        $this->db->where('profile.role_id =', 2);
        $this->db->join('role', 'role.id = profile.role_id', 'left');
        $this->db->join('accounts', 'accounts.id = profile.id', 'left');
        if ($keyword) {
            $this->db->like('nama', $keyword);
        }

        return $this->db->get('profile', $number, $offset)->result_array();
    }
    public function tambahGuru()
    {
        $account = array(
            'id' => $this->input->post('id', true),
            'email' => $this->input->post('email', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'is_active' => 1,
            'date_created' => date("Y-m-d H:i:s")
        );

        $data_guru = array(
            'id' => $this->input->post('id', true),
            'nama' => $this->input->post('nama', true),
            'asal' => $this->input->post('asal', true),
            'tglahir' => $this->input->post('tglahir', true),
            'image' => 'not.jpg',
            'role_id' => 2,
        );

        $jum_mapel = $this->input->post('mapel', true);
        for ($i = 0; $i < count($jum_mapel); $i++) {
            $mapel_guru = array(
                'id' => $this->input->post('id', true),
                'mapel' => $this->input->post('mapel', true)[$i]
            );
            $this->db->insert('guru', $mapel_guru);
        }

        $this->db->insert('profile', $data_guru);
        $this->db->insert('accounts', $account);
    }
    public function editGuru()
    {
        $dt_lama = $this->db->get_where('accounts', ['id' => $this->input->post('id_lama', true)])->row_array();

        if ($this->input->post('password', true) == "") {
            $password = $dt_lama['password'];
        } else {
            $password = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
        }

        $account = array(
            'id' => $this->input->post('id', true),
            'email' => $this->input->post('email', true),
            'password' => $password,
            'is_active' => 1
        );

        $data_guru = array(
            'id' => $this->input->post('id', true),
            'nama' => $this->input->post('nama', true),
            'asal' => $this->input->post('asal', true),
            'tglahir' => $this->input->post('tglahir', true)
        );

        $this->db->where('id', $this->input->post('id_lama', true));
        $this->db->delete('guru');

        $jum_mapel = $this->input->post('mapel', true);
        for ($i = 0; $i < count($jum_mapel); $i++) {
            $mapel_guru = array(
                'id' => $this->input->post('id', true),
                'mapel' => $this->input->post('mapel', true)[$i]
            );
            $this->db->insert('guru', $mapel_guru);
        }

        $this->db->where('id', $this->input->post('id_lama'));
        $this->db->update('profile', $data_guru);

        $this->db->where('id', $this->input->post('id_lama'));
        $this->db->update('accounts', $account);
    }
    public function mapelGuru($id)
    {
        $this->db->select('*');
        $this->db->where('a.id', $id);

        $this->db->join('ref_mapel b', 'b.id = a.mapel', 'left');
        return $this->db->get('guru a')->result_array();
    }
    public function kelasGuru($id_guru)
    {
        $this->db->select('*, a.id id_jadwal');
        $this->db->where('a.id_guru', $id_guru);

        $this->db->join('ref_mapel b', 'b.id = a.id_mapel', 'left');
        return $this->db->get('jadwal a')->result_array();
    }
    public function detailMapelGuru($id, $mapel)
    {
        return $this->db->get_where('guru', ['id' => $id, 'mapel' => $mapel])->result_array();
    }
    public function detailGuru($id)
    {
        $this->db->select('*, profile.id id_guru');
        $this->db->where('profile.id =', $id);
        $this->db->where('profile.role_id =', 2);
        $this->db->join('role', 'role.id = profile.role_id', 'left');
        $this->db->join('accounts', 'accounts.id = profile.id', 'left');

        return $this->db->get('profile')->row_array();
    }
    public function hapusDataGuru($id)
    {
        $data = $this->db->get_where('profile', ['id' => $id])->row_array();
        if ($data['image'] != 'not.jpg') {
            unlink(FCPATH . 'assets/img-profile/' . $data['image']);
        }

        $this->db->where('id', $id);
        $this->db->delete('accounts');

        $this->db->where('id', $id);
        $this->db->delete('guru');

        $this->db->where('id', $id);
        $this->db->delete('profile');
    }
    // end of guru Model

    // start of mapel model
    public function getAllMapel()
    {
        return $this->db->get('ref_mapel')->result_array();
    }
    public function tambahMapel()
    {
        $this->db->insert('ref_mapel', ['nama_mapel' => $this->input->post('nama_mapel')]);
    }
    public function editMapel()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('ref_mapel', ['nama_mapel' => $this->input->post('nama_mapel')]);
    }
    public function hapusMapel($id)
    {
        $this->db->where('mapel', $id);
        $this->db->delete('guru');

        $this->db->where('id', $id);
        $this->db->delete('ref_mapel');
    }
    // end mapel model

    // start siswa model
    public function getAllSiswa($number, $offset, $keyword = null)
    {
        $this->db->select('*, profile.id id_siswa');
        $this->db->where('profile.id !=', 1234);
        $this->db->where('profile.role_id =', 3);
        $this->db->join('role', 'role.id = profile.role_id', 'left');
        $this->db->join('accounts', 'accounts.id = profile.id', 'left');
        if ($keyword) {
            $this->db->like('nama', $keyword);
        }

        return $this->db->get('profile', $number, $offset)->result_array();
    }
    public function tambahSiswa()
    {
        $account = array(
            'id' => $this->input->post('id', true),
            'email' => $this->input->post('email', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT),
            'is_active' => 1,
            'date_created' => date("Y-m-d H:i:s")
        );

        $data_siswa = array(
            'id' => $this->input->post('id', true),
            'nama' => $this->input->post('nama', true),
            'asal' => $this->input->post('asal', true),
            'tglahir' => $this->input->post('tglahir', true),
            'image' => 'not.jpg',
            'role_id' => 3,
        );

        $kls_siswa = array(
            'id' => $this->input->post('id', true),
            'kelas' => $this->input->post('kelas', true)
        );

        $this->db->insert('profile', $data_siswa);
        $this->db->insert('accounts', $account);
        $this->db->insert('siswa', $kls_siswa);
    }
    public function detailSiswa($id)
    {
        $this->db->select('*, profile.id id_siswa');
        $this->db->where('profile.id =', $id);
        $this->db->where('profile.role_id =', 3);
        $this->db->join('role', 'role.id = profile.role_id', 'left');
        $this->db->join('accounts', 'accounts.id = profile.id', 'left');

        return $this->db->get('profile')->row_array();
    }
    public function editSiswa()
    {
        $dt_lama = $this->db->get_where('accounts', ['id' => $this->input->post('id_lama', true)])->row_array();

        if ($this->input->post('password', true) == "") {
            $password = $dt_lama['password'];
        } else {
            $password = password_hash($this->input->post('password', true), PASSWORD_DEFAULT);
        }

        $account = array(
            'id' => $this->input->post('id', true),
            'email' => $this->input->post('email', true),
            'password' => $password,
            'is_active' => 1
        );

        $data_siswa = array(
            'id' => $this->input->post('id', true),
            'nama' => $this->input->post('nama', true),
            'asal' => $this->input->post('asal', true),
            'tglahir' => $this->input->post('tglahir', true)
        );

        $kls_siswa = array(
            // 'id' => $this->input->post('id', true),
            'kelas' => $this->input->post('kelas', true)
        );

        $this->db->where('id', $this->input->post('id_lama'));
        $this->db->update('profile', $data_siswa);

        $this->db->where('id', $this->input->post('id_lama'));
        $this->db->update('accounts', $account);

        $this->db->where('id', $this->input->post('id_lama'));
        $this->db->update('siswa', $kls_siswa);
        // $this->db->where('id', $this->input->post('id_lama'));
        // $this->db->delete('siswa');

        // $this->db->insert('siswa', $kls_siswa);
    }
    public function hapusDataSiswa($id)
    {
        $data = $this->db->get_where('profile', ['id' => $id])->row_array();
        if ($data['image'] != 'not.jpg') {
            unlink(FCPATH . 'assets/img-profile/' . $data['image']);
        }

        $this->db->where('id', $id);
        $this->db->delete('accounts');

        $this->db->where('id', $id);
        $this->db->delete('profile');
    }
    public function kelasSiswa($id_siswa)
    {
        $this->db->select('*');
        $this->db->where('a.id', $id_siswa);

        return $this->db->get('siswa a')->result_array();
    }
    // end siswa model

    // start jadwal model
    public function getKelas()
    {
        $this->db->distinct();
        $this->db->select('nama_kls');
        $this->db->group_by("nama_kls");

        return $this->db->get('jadwal')->result_array();
    }
    public function getDetailKelas($keyword = null)
    {
        $this->db->distinct();
        $this->db->select('nama_kls');
        $this->db->group_by("nama_kls");
        if ($keyword) {
            $this->db->like('nama_kls', $keyword);
        }

        return $this->db->get('jadwal')->result_array();
    }
    public function getDetailJadwal($nama_kls = '', $hari = '')
    {
        $this->db->select('*, jadwal.id id_kls');
        $this->db->join('ref_mapel', 'ref_mapel.id = jadwal.id_mapel', 'left');
        $this->db->join('profile', 'profile.id = jadwal.id_guru', 'left');
        $this->db->where('nama_kls =', $nama_kls);
        $this->db->where('hari =', $hari);
        $this->db->order_by('jam_masuk', 'ASC');

        return $this->db->get('jadwal')->result_array();
    }
    public function guruDetail($id_mapel = 0)
    {
        $this->db->distinct();
        $this->db->select('*');
        $this->db->join('profile', 'profile.id = guru.id', 'left');
        $this->db->where('mapel =', $id_mapel);
        $this->db->group_by("guru.id");

        return $this->db->get('guru')->result_array();
    }
    public function tambahKelas()
    {
        $cek_jadwal = $this->db->get_where('jadwal', ['hari' => $this->input->post('hari', true), 'jam_masuk' => $this->input->post('jam_masuk', true), 'jam_keluar' => $this->input->post('jam_keluar', true), 'id_guru' => $this->input->post('id_guru', true)])->row_array();

        if (!$cek_jadwal) {
            $kelas = array(
                'nama_kls' => $this->input->post('nama_kls', true),
                'id_mapel' => $this->input->post('id_mapel', true),
                'hari' => $this->input->post('hari', true),
                'jam_masuk' => $this->input->post('jam_masuk', true),
                'jam_keluar' => $this->input->post('jam_keluar', true),
                'id_guru' => $this->input->post('id_guru', true)
            );

            $this->db->insert('jadwal', $kelas);
            $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Kelas Berhasil Ditambahkan.</div>');
            redirect('admin/jadwal_kelas');
        } else {
            $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Jadwal Mata Pelajaran Tersebut Sudah Ada.</div>');
            redirect('admin/tambah_kelas');
        }
    }
    public function tambahJadwal()
    {
        $cek_jadwal = $this->db->get_where('jadwal', ['hari' => $this->input->post('hari', true), 'jam_masuk' => $this->input->post('jam_masuk', true), 'jam_keluar' => $this->input->post('jam_keluar', true), 'id_guru' => $this->input->post('id_guru', true)])->row_array();

        if (!$cek_jadwal) {
            $cek_jadwal2 = $this->db->get_where('jadwal', ['hari' => $this->input->post('hari', true), 'jam_masuk' => $this->input->post('jam_masuk', true), 'jam_keluar' => $this->input->post('jam_keluar', true)])->row_array();

            if (!$cek_jadwal2) {
                $kelas = array(
                    'nama_kls' => $this->input->post('nama_kls', true),
                    'id_mapel' => $this->input->post('id_mapel', true),
                    'hari' => $this->input->post('hari', true),
                    'jam_masuk' => $this->input->post('jam_masuk', true),
                    'jam_keluar' => $this->input->post('jam_keluar', true),
                    'id_guru' => $this->input->post('id_guru', true)
                );

                $this->db->insert('jadwal', $kelas);
                $this->session->set_flashdata('flash', '<div class="alert alert-success" role="alert">Jadwal Mata Pelajaran Berhasil Ditambah.</div>');
                redirect('admin/jadwal_kelas');
            } else {
                $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Jam Pelajaran Tersebut Sudah Ada.</div>');
                redirect('admin/jadwal_kelas');
            }
        } else {
            $this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Jadwal Mata Pelajaran Tersebut Sudah Ada.</div>');
            redirect('admin/jadwal_kelas');
        }
    }
    public function hapusDataJadwal($id)
    {
        $det_materi = $this->db->get_where('jadwal', ['id' => $id])->row_array();

        unlink(FCPATH . 'assets/materi/' . $det_materi['materi']);

        $this->db->where('id', $id);
        $this->db->delete('jadwal');
    }
    public function hapusDataKelas($nama_kls)
    {
        $this->db->where('nama_kls', $nama_kls);
        $this->db->delete('jadwal');
    }
}
