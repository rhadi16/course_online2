<!--Container Main start-->
<div class="my-container active-cont position-relative">
    <!-- Top Nav -->
    <nav class="navbar top-navbar navbar-light bg-dark px-5 sticky-top">
        <a class="btn border-0" id="menu-btn"><i class="fas fa-bars"></i></a>
    </nav>
    <div class="container mt-3">
        <?= $this->session->flashdata('flash'); ?>
    </div>
    <!--End Top Nav -->
    <h4 class="text-center mb-3 mt-3">Jadwal Kelas <?= $siswa['kelas']; ?></h4>
    <?php if (empty($siswa)) : ?>
        <div class="alert alert-danger text-center mt-3" role="alert">
            Kelas Tidak Ditemukan
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="row justify-content-center mt-3 mb-4">
            <?php foreach ($hari as $h) : ?>
                <div class="col-sm-6 col-md-4 mb-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold fs-6" id="hari"><?= $h; ?></h5>
                            <?php $jadwal = $this->Siswa_model->jadwalSiswa($siswa['kelas'], $h); ?>
                            <?php if (empty($jadwal)) : ?>
                                <span class="fw-normal size-08 text-danger">Jadwal Belum Ada</span>
                            <?php endif; ?>
                            <table class="table table-sm align-middle table-jadwal mx-auto table-borderless mb-0 text-capitalize">
                                <tbody>
                                    <?php foreach ($jadwal as $j) : ?>
                                        <tr class="border border-bottom-0">
                                            <th scope="row" class="text-break"><?= $j['nama_mapel']; ?></th>
                                            <td><?= date('H:i', strtotime($j['jam_masuk'])); ?></td>
                                            <td>-</td>
                                            <td><?= date('H:i', strtotime($j['jam_keluar'])); ?></td>
                                        </tr>
                                        <tr class="border border-top-0">
                                            <th colspan="4" scope="row" class="text-break">
                                                <a class="fs-6 pointer" data-bs-toggle="modal" data-bs-target="#detail-jadwal<?= $j['id_kls']; ?>"><i class="fa-solid fa-circle-info"></i></a>
                                                <?= $j['nama']; ?>
                                            </th>
                                        </tr>

                                        <!-- Modal detail kelas -->
                                        <div class="modal fade" id="detail-jadwal<?= $j['id_kls']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title mx-auto" id="exampleModalLabel">Detail Jadwal</h5>
                                                    </div>
                                                    <div class="modal-body text-capitalize">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><?= $j['nama_mapel']; ?></li>
                                                            <li class="list-group-item">
                                                                <?= $h; ?>,
                                                                <?= date('H:i', strtotime($j['jam_masuk'])); ?>
                                                                -
                                                                <?= date('H:i', strtotime($j['jam_keluar'])); ?>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <?php if (isset($j['link_kls'])) { ?><a href="<?= $j['link_kls']; ?>" class="text-decoration-none" target="_blank">Gabung Kelas</a>
                                                                <?php } else {
                                                                    echo "Belum Ada Link Kelas";
                                                                } ?>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <?php if (isset($j['link_meet'])) { ?><a href="<?= $j['link_meet']; ?>" class="text-decoration-none" target="_blank">Gabung Meeting</a>
                                                                <?php } else {
                                                                    echo "Belum Ada Link Meeting";
                                                                } ?>
                                                            </li>
                                                            <li class="list-group-item">
                                                                <?php
                                                                if (isset($j['materi'])) {
                                                                    $format = explode('.', $j['materi']);
                                                                    if ($format[1] == 'pdf') {
                                                                        echo '<a class="text-decoration-none" href="' . base_url('siswa/download_materi/' . $j['materi']) . '"><i class="fa-solid fa-file-pdf fs-4 text-warning"></i> ' . $j['materi'] . '</a>';
                                                                    } elseif ($format[1] == 'xlx' || $format[1] == 'xlsx') {
                                                                        echo '<a class="text-decoration-none" href="' . base_url('siswa/download_materi/' . $j['materi']) . '"><i class="fa-solid fa-file-excel fs-4 text-success"></i> ' . $j['materi'] . '</a>';
                                                                    } elseif ($format[1] == 'ppt' || $format[1] == 'pptx') {
                                                                        echo '<a class="text-decoration-none" href="' . base_url('siswa/download_materi/' . $j['materi']) . '"><i class="fa-solid fa-file-powerpoint fs-4 text-danger"></i> ' . $j['materi'] . '</a>';
                                                                    } else {
                                                                        echo '<a class="text-decoration-none" href="' . base_url('siswa/download_materi/' . $j['materi']) . '"><i class="fa-solid fa-file fs-4 text-danger"></i> ' . $j['materi'] . '</a>';
                                                                    }
                                                                } else {
                                                                    echo "Belum Ada Materi";
                                                                }
                                                                ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--Container Main end-->