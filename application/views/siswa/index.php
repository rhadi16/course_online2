<!-- Main Wrapper -->
<div class="my-container active-cont position-relative">
    <!-- Top Nav -->
    <nav class="navbar top-navbar navbar-light bg-dark px-5 sticky-top">
        <a class="btn border-0" id="menu-btn"><i class="fas fa-bars"></i></a>
    </nav>
    <!--End Top Nav -->
    <h3 class="text-dark p-3 h3 text-center">Selamat Datang Siswa!</h3>
    <div class="px-3">
        <div class="card mb-3 mx-auto h-auto col-lg-7 col-md-9 shadow">
            <div class="row g-0">
                <div class="col-md-6 col-sm-12">
                    <div class="img-profile h-100 w-100 rounded" style="background-image: url('<?= base_url('assets/img-profile/') . $profile['image']; ?>')"></div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title text-capitalize"><?= $profile['nama']; ?></h5>
                        <p class="card-text"><?= $account['email']; ?></p>
                        <p class="card-text"><small class="text-muted"><?= date_indo(date('Y-m-d', strtotime($account['date_created']))); ?></small></p>
                        <p class="card-text">Kelas <?= $retVal = (isset($siswa['kelas'])) ? $siswa['kelas'] : "Belum Ada"; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>