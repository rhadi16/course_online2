<div class="container pt-3 mb-5">
    <?= $this->session->flashdata('flash'); ?>
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow">
                <h5 class="card-header text-center">Form Tambah Kelas</h5>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        <div class="mb-3">
                            <label for="nama_kls" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" id="nama_kls" name="nama_kls" value="<?= $input['nama_kls']; ?>">
                            <div class="form-text text-danger"><?= form_error('nama_kls'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="id_mapel" class="form-label">Nama Mata Pelajaran</label>
                            <select class="form-select" aria-label="Default select example" name="id_mapel" id="id_mapel">
                                <option selected value="0">Pilih Mata Pelajaran</option>
                                <?php foreach ($mapel as $m) : ?>
                                    <option value="<?= $m['id']; ?>"><?= $m['nama_mapel']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text text-danger"><?= form_error('id_mapel'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select class="form-select" aria-label="Default select example" id="hari" name="hari">
                                <option selected value="0">Pilih Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                            <div class="form-text text-danger"><?= form_error('hari'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="jam_masuk" class="form-label">Jam Masuk</label>
                            <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="<?= $input['jam_masuk']; ?>">
                            <div class="form-text text-danger"><?= form_error('jam_masuk'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="jam_keluar" class="form-label">Jam Keluar</label>
                            <input type="time" class="form-control" id="jam_keluar" name="jam_keluar" value="<?= $input['jam_keluar']; ?>">
                            <div class="form-text text-danger"><?= form_error('jam_keluar'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="detail_guru" class="form-label">Nama Guru</label>
                            <select class="form-select" aria-label="Default select example" name="id_guru" id="detail-guru">
                                <option selected value="0">Pilih Guru</option>
                            </select>
                            <div class="form-text text-danger"><?= form_error('id_guru'); ?></div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                        <a href="<?= base_url('admin/jadwal_kelas'); ?>" class="btn btn-danger mx-2 float-end">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>