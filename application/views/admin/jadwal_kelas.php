<!--Container Main start-->
<div class="container pt-3">
    <h4 class="text-center mb-3">Daftar Kelas</h4>
    <?= $this->session->flashdata('flash'); ?>
    <div class="row justify-content-between mb-3">
        <div class="col-md-5 col-sm-12 mb-3">
            <form action="" method="post" class="input-group">
                <input type="hidden" id="csrf" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                <select class="form-select" name="keyword">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelases as $kls) : ?>
                        <option <?= $retVal = ($kls['nama_kls'] == $this->session->userdata('keyword')) ? "selected" : ''; ?> value="<?= $kls['nama_kls']; ?>"><?= $kls['nama_kls']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="btn btn-primary" type="submit" name="submit" value="Cari" id="button">
            </form>
        </div>
        <div class="col-md-5 col-sm-12 d-flex justify-content-end">
            <div>
                <a href="<?= base_url('admin/tambah_kelas'); ?>" class="btn btn-primary">Tambah Kelas</a>
            </div>
        </div>
    </div>
    <?php if (empty($kelas)) : ?>
        <div class="alert alert-danger text-center mt-3" role="alert">
            Kelas Tidak Ditemukan
        </div>
    <?php endif; ?>
    <?php foreach ($kelas as $kls) : ?>
        <h5 class="text-center">Kelas <?= $kls['nama_kls']; ?></h5>
        <a class="badge text-bg-success pointer" data-bs-toggle="modal" data-bs-target="#tambah-mapel-kls<?= $kls['nama_kls']; ?>">Tambah Mata Pelajaran</a>
        <a class="badge text-bg-danger pointer" onclick="hapusKelas('<?= $kls['nama_kls']; ?>', '<?= base_url('admin/hapus_kelas/') . $kls['nama_kls']; ?>')">Hapus Kelas</a>
        <!-- Modal add jadwal -->
        <div class="modal fade" id="tambah-mapel-kls<?= $kls['nama_kls']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Form Tambah Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" id="csrf<?= $kls['nama_kls']; ?>" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="nama_kls" name="nama_kls" value="<?= $kls['nama_kls']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="id_mapel" class="form-label">Nama Mata Pelajaran</label>
                                <select class="form-select" aria-label="Default select example" name="id_mapel" id="id_mapel<?= $kls['nama_kls']; ?>" onchange="selectGuru('<?= $kls['nama_kls']; ?>')">
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
                                <input type="time" class="form-control" id="jam_masuk" name="jam_masuk">
                                <div class="form-text text-danger"><?= form_error('jam_masuk'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar">
                                <div class="form-text text-danger"><?= form_error('jam_keluar'); ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="detail_guru" class="form-label">Nama Guru</label>
                                <select class="form-select" aria-label="Default select example" name="id_guru" id="detail-guru<?= $kls['nama_kls']; ?>">
                                    <option selected value="0">Pilih Guru</option>
                                </select>
                                <div class="form-text text-danger"><?= form_error('id_guru'); ?></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end add jadwal -->
        <div class="row justify-content-center mt-3 mb-4">
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Senin</h5>
                        <?php $seninJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Senin'); ?>
                        <?php if (empty($seninJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($seninJadwal as $senj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $senj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $senj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $senj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($senj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($senj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $senj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Selasa</h5>
                        <?php $selasaJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Selasa'); ?>
                        <?php if (empty($selasaJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($selasaJadwal as $selj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $selj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $selj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $selj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($selj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($selj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $selj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Rabu</h5>
                        <?php $rabuJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Rabu'); ?>
                        <?php if (empty($rabuJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($rabuJadwal as $rabj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $rabj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $rabj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $rabj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($rabj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($rabj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $rabj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Kamis</h5>
                        <?php $kamisJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Kamis'); ?>
                        <?php if (empty($kamisJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($kamisJadwal as $kamj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $kamj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $kamj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $kamj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($kamj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($kamj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $kamj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Jumat</h5>
                        <?php $jumatJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Jumat'); ?>
                        <?php if (empty($jumatJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($jumatJadwal as $jumj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $jumj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $jumj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $jumj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($jumj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($jumj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $jumj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Sabtu</h5>
                        <?php $sabtuJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Sabtu'); ?>
                        <?php if (empty($sabtuJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($sabtuJadwal as $sabj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $sabj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $sabj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $sabj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($sabj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($sabj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $sabj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold fs-6" id="hari">Minggu</h5>
                        <?php $mingguJadwal = $this->Admin_model->getDetailJadwal($kls['nama_kls'], 'Minggu'); ?>
                        <?php if (empty($mingguJadwal)) : ?>
                            <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                        <?php endif; ?>
                        <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0">
                            <tbody>
                                <?php foreach ($mingguJadwal as $minj) : ?>
                                    <tr class="border border-bottom-0">
                                        <th scope="row" class="text-break"><a class="link-danger pointer" onclick="hapusJadwal('<?= $minj['nama_mapel']; ?>', '<?= base_url('admin/hapus_jadwal/') . $minj['id_kls']; ?>')"><i class="fa-solid fa-trash"></i></a> <?= $minj['nama_mapel']; ?></th>
                                        <td><?= date('H:i', strtotime($minj['jam_masuk'])); ?></td>
                                        <td>-</td>
                                        <td><?= date('H:i', strtotime($minj['jam_keluar'])); ?></td>
                                    </tr>
                                    <tr class="border border-top-0">
                                        <th colspan="4" scope="row" class="text-break"><?= $minj['nama']; ?></th>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!--Container Main end-->