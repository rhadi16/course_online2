<!-- Main Wrapper -->
<div class="my-container active-cont position-relative">
    <!-- Top Nav -->
    <nav class="navbar top-navbar navbar-light bg-dark px-5 sticky-top">
        <a class="btn border-0" id="menu-btn"><i class="fas fa-bars"></i></a>
    </nav>
    <div class="container mt-3">
        <?= $this->session->flashdata('flash'); ?>
    </div>
    <!--End Top Nav -->
    <div class="container mt-3">
        <h4 class="text-center mb-3">Daftar Kelas</h4>
        <div class="table-responsive">
            <table id="mapel" class="table table-striped align-middle text-center table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-center text-mapel-guru">No.</th>
                        <th class="text-center text-mapel-guru">Nama Mata Pelajaran</th>
                        <th class="text-center text-mapel-guru">Hari, dan Jam</th>
                        <th class="text-center text-mapel-guru">Link Diskusi Kelas</th>
                        <th class="text-center text-mapel-guru">Link Meeting</th>
                        <th class="text-center text-mapel-guru">Materi</th>
                        <th class="text-center text-mapel-guru">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($kGuru as $kg) : ?>
                        <tr>
                            <td class="text-mapel-guru"><?= $no++; ?>.</td>
                            <td class="text-mapel-guru"><?= $kg['nama_mapel']; ?></td>
                            <td class="text-mapel-guru"><?= $kg['hari'] . ', ' . date('H:i', strtotime($kg['jam_masuk'])) . ' - ' . date('H:i', strtotime($kg['jam_keluar'])); ?></td>
                            <td class="text-mapel-guru text-break">
                                <?php if (isset($kg['link_kls'])) { ?><a href="<?= $kg['link_kls']; ?>" class="text-decoration-none" target="_blank">Gabung Kelas</a>
                                <?php } ?>
                            </td>
                            <td class="text-mapel-guru text-break">
                                <?php if (isset($kg['link_meet'])) { ?><a href="<?= $kg['link_meet']; ?>" class="text-decoration-none" target="_blank">Gabung Meet</a>
                                <?php } ?>
                            </td>
                            <td class="text-mapel-guru text-break align-middle text-wrap">
                                <?php
                                if (isset($kg['materi'])) {
                                ?>
                                    <a onclick="hapusMateri('<?= $kg['materi']; ?>', '<?= base_url('guru/hapus_materi/') . $kg['materi']; ?>')" class="link-danger pointer fs-6"><i class="fa-solid fa-trash"></i></a>
                                <?php
                                    $format = explode('.', $kg['materi']);
                                    if ($format[1] == 'pdf') {
                                        echo '<a class="text-decoration-none" href="' . base_url('guru/download_materi/' . $kg['materi']) . '"><i class="fa-solid fa-file-pdf fs-4 text-warning"></i> ' . $kg['materi'] . '</a>';
                                    } elseif ($format[1] == 'xlx' || $format[1] == 'xlsx') {
                                        echo '<a class="text-decoration-none" href="' . base_url('guru/download_materi/' . $kg['materi']) . '"><i class="fa-solid fa-file-excel fs-4 text-success"></i> ' . $kg['materi'] . '</a>';
                                    } elseif ($format[1] == 'ppt' || $format[1] == 'pptx') {
                                        echo '<a class="text-decoration-none" href="' . base_url('guru/download_materi/' . $kg['materi']) . '"><i class="fa-solid fa-file-powerpoint fs-4 text-danger"></i> ' . $kg['materi'] . '</a>';
                                    } else {
                                        echo '<a class="text-decoration-none" href="' . base_url('guru/download_materi/' . $kg['materi']) . '"><i class="fa-solid fa-file fs-4 text-danger"></i> ' . $kg['materi'] . '</a>';
                                    }
                                } else {
                                    echo "Belum Ada Materi";
                                }
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning text-light" data-bs-toggle="modal" data-bs-target="#edit-jadwal<?= $kg['id_jadwal']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                            </td>
                        </tr>
                        <!-- Modal edit mapel -->
                        <div class="modal fade" id="edit-jadwal<?= $kg['id_jadwal']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title mx-auto" id="exampleModalLabel">Form Edit Jadwal</h5>
                                    </div>
                                    <?= form_open_multipart(''); ?>
                                    <div class="modal-body">
                                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                                        <input type="hidden" name="id" value="<?= $kg['id_jadwal']; ?>">
                                        <input type="hidden" name="materi" value="<?= $kg['materi']; ?>">
                                        <div class="mb-3">
                                            <label for="link_kls" class="form-label">Link Diskusi Kelas</label>
                                            <input type="text" class="form-control" id="link_kls" name="link_kls" value="<?= $kg['link_kls']; ?>">
                                            <div class="form-text text-danger text-center"><?= form_error('link_kls'); ?></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="link_meet" class="form-label">Link Meeting</label>
                                            <input type="text" class="form-control" id="link_meet" name="link_meet" value="<?= $kg['link_meet']; ?>">
                                            <div class="form-text text-danger text-center"><?= form_error('link_meet'); ?></div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="materi" class="form-label">Upload Materi</label>
                                            <input type="file" class="form-control" id="materi" name="materi">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end modal edit mapel -->
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center text-mapel-guru">No.</th>
                        <th class="text-center text-mapel-guru">Nama Mata Pelajaran</th>
                        <th class="text-center text-mapel-guru">Hari, dan Jam</th>
                        <th class="text-center text-mapel-guru">Link Diskusi Kelas</th>
                        <th class="text-center text-mapel-guru">Link Meeting</th>
                        <th class="text-center text-mapel-guru">Materi</th>
                        <th class="text-center text-mapel-guru">Option</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>