<!--Container Main start-->
<div class="container pt-3">
    <h4 class="text-center mb-3">Daftar Guru</h4>
    <?= $this->session->flashdata('flash'); ?>
    <div class="row justify-content-between">
        <div class="col-md-5 col-sm-12 mb-3">
            <a href="<?= base_url('admin/tambah_guru'); ?>" class="btn btn-primary">Tambah Guru</a>
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
    <?php if (empty($guru)) : ?>
        <div class="alert alert-danger text-center mt-3" role="alert">
            Data Guru Tidak Ditemukan
        </div>
    <?php endif; ?>
    <div class="row justify-content-center mt-3">
        <?php foreach ($guru as $g) : ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow">
                    <div class="w-100 card-img-top">
                        <div class="img-profile h-100 w-100 rounded" style="background-image: url('<?= base_url('assets/img-profile/') . $g['image']; ?>')"></div>
                    </div>
                    <div class="card-body text-center pb-0">
                        <h5 class="card-title fw-bold fs-6" id="nama"><?= $g['nama']; ?></h5>
                        <?php $mGuru = $this->Admin_model->mapelGuru($g['id_guru']); ?>
                        <?php foreach ($mGuru as $mg) : ?>
                            <span class="text-mapel-guru"><?= $mg['nama_mapel']; ?></span><br>
                        <?php endforeach; ?>
                    </div>
                    <div class="card-body d-flex justify-content-center flex-nowrap w-100">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm my-1 mx-1" data-bs-toggle="modal" data-bs-target="#detail-guru<?= $g['id_guru']; ?>">
                            <i class="fa-solid fa-circle-info"></i>
                        </button>
                        <a href="<?= base_url('admin/edit_guru/') . $g['id_guru']; ?>" class="btn btn-warning btn-sm text-light my-1 mx-1"><i class="fa-solid fa-pen-to-square"></i></a>
                        <button type="button" class="btn btn-danger btn-sm my-1 mx-1" onclick="hapusGuru('<?= $g['nama']; ?>', '<?= base_url('admin/hapus_guru/') . $g['id_guru']; ?>')"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>

                <!-- Start Modal Detail Guru -->
                <div class="modal fade" id="detail-guru<?= $g['id_guru']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mx-auto" id="exampleModalLabel">Detail Guru</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <img src="<?= base_url('assets/img-profile/') . $g['image']; ?>" class="img-fluid rounded shadow" alt="...">
                                    </div>
                                    <div class="col-12 mt-3">
                                        <table class="table table-borderless mb-0 table-sm">
                                            <tbody>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">ID</th>
                                                    <td class="text-mapel-guru"><?= $g['id_guru']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">Nama</th>
                                                    <td class="text-mapel-guru"><?= $g['nama']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">Email</th>
                                                    <td class="text-mapel-guru"><?= $g['email']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">Tempat, Tanggal Lahir</th>
                                                    <td class="text-mapel-guru"><?= $g['asal'] . ', ' . date_indo($g['tglahir']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">Guru</th>
                                                    <td class="text-mapel-guru"><?php foreach ($mGuru as $mg) : ?>
                                                            <i class="fa-solid fa-arrow-right"></i> <?= $mg['nama_mapel']; ?><br>
                                                        <?php endforeach; ?>
                                                    </td>
                                                </tr>
                                                <?php $kGuru = $this->Admin_model->kelasGuru($g['id_guru']); ?>
                                                <tr>
                                                    <th scope="row" class="text-mapel-guru">Kelas Yang Diajar</th>
                                                    <td class="text-mapel-guru"><?php foreach ($kGuru as $kg) : ?>
                                                            <i class="fa-solid fa-arrow-right"></i> <?= $kg['nama_kls'] . ' ' . $kg['nama_mapel'] . ' hari ' . $kg['hari'] . ' jam ' . date('H:i', strtotime($kg['jam_masuk'])) . ' - ' . date('H:i', strtotime($kg['jam_keluar'])); ?><br>
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