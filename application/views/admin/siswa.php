<!--Container Main start-->
<div class="container pt-3">
    <h4 class="text-center mb-3">Daftar Siswa</h4>
    <?= $this->session->flashdata('flash'); ?>
    <div class="row justify-content-between">
        <div class="col-md-5 col-sm-12 mb-3">
            <a href="<?= base_url('admin/tambah_siswa'); ?>" class="btn btn-primary">Tambah Siswa</a>
        </div>
        <div class="col-md-5 col-sm-12">
            <form action="" method="post" class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Data Akun" name="keyword" value="<?= $this->session->userdata('keyword'); ?>" id="search">
                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                <!-- <button class="btn btn-primary" type="submit">Cari</button> -->
                <input class="btn btn-primary" type="submit" name="submit" value="Cari" id="button">
            </form>
            <?php if ($this->session->userdata('keyword') != '') { ?>
                <form action="" method="post">
                    <input type="hidden" name="keyword" value="">
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                    <!-- <button class="btn btn-primary" type="submit">Cari</button> -->
                    <input class="btn btn-danger" type="submit" name="submit" value="Batal Cari">
                </form>
            <?php } ?>
        </div>
    </div>
    <?php if (empty($siswa)) : ?>
        <div class="alert alert-danger text-center mt-3" role="alert">
            Data Siswa Tidak Ditemukan
        </div>
    <?php endif; ?>
    <div class="row justify-content-center mt-3">
        <?php foreach ($siswa as $s) : ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <?php $ksiswa = $this->Admin_model->kelasSiswa($s['id_siswa']); ?>
                <div class="card shadow">
                    <div class="w-100 card-img-top">
                        <div class="img-profile h-100 w-100 rounded" style="background-image: url('<?= base_url('assets/img-profile/') . $s['image']; ?>')"></div>
                    </div>
                    <div class="card-body text-center pb-0">
                        <h5 class="card-title fw-bold fs-6" id="nama"><?= $s['nama']; ?></h5>
                        <p class="text-siswa">
                            <?php if (!$ksiswa) {
                                echo "Belum Ada Kelas";
                            }
                            foreach ($ksiswa as $ks) : ?>
                                Kelas <?= $ks['kelas']; ?><br>
                            <?php endforeach; ?>
                        </p>
                    </div>
                    <div class="card-body d-flex justify-content-center flex-nowrap w-100">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm my-1 mx-1" data-bs-toggle="modal" data-bs-target="#detail-siswa<?= $s['id_siswa']; ?>">
                            <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <a href="<?= base_url('admin/edit_siswa/') . $s['id_siswa']; ?>" class="btn btn-warning btn-sm text-light my-1 mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button type="button" class="btn btn-danger btn-sm my-1 mx-1" onclick="hapusSiswa('<?= $s['nama']; ?>', '<?= base_url('admin/hapus_siswa/') . $s['id_siswa']; ?>')"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>

                <!-- Start Modal Detail Guru -->
                <div class="modal fade" id="detail-siswa<?= $s['id_siswa']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="exampleModalLabel">Detail Siswa</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <img src="<?= base_url('assets/img-profile/') . $s['image']; ?>" class="img-fluid rounded shadow" alt="...">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <table class="table table-borderless mb-0 table-sm">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="text-siswa">ID</th>
                                                    <td class="text-siswa"><?= $s['id_siswa']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-siswa">Nama</th>
                                                    <td class="text-siswa"><?= $s['nama']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-siswa">Email</th>
                                                    <td class="text-siswa"><?= $s['email']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-siswa">Tempat, Tanggal Lahir</th>
                                                    <td class="text-siswa"><?= $s['asal'] . ', ' . date_indo($s['tglahir']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">Kelas</th>
                                                    <td class="text-mapel-guru"><?php if (!$ksiswa) {
                                                                                    echo "Belum Ada Kelas";
                                                                                }
                                                                                foreach ($ksiswa as $ks) : ?>
                                                            <i class="fa-solid fa-arrow-right"></i> <?= $ks['kelas']; ?><br>
                                                        <?php endforeach; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Of Modal Detail Guru -->
            </div>
        <?php endforeach; ?>
    </div>
    <?php echo $this->pagination->create_links(); ?>
</div>
<!--Container Main end-->