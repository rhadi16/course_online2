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
    <h3 class="text-dark p-3 h3 text-center">Setting Password Anda!</h3>
    <div class="px-3">
        <div class="card mb-3 mx-auto h-auto col-lg-7 col-md-9 shadow">
            <div class="card-body">
                <form action="<?= base_url('siswa/settingpassword'); ?>" method="post">
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                    <input type="hidden" name="id" value="<?= $profile['id']; ?>">
                    <div class="mb-3">
                        <label for="password_lama" class="form-label">Masukkan Password Sekarang</label>
                        <input type="password" class="form-control" id="password_lama" name="password_lama">
                        <?= form_error('password_lama', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru1" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password_baru1" name="password_baru1">
                        <?= form_error('password_baru1', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru2" class="form-label">Repeat Password Baru</label>
                        <input type="password" class="form-control" id="password_baru2" name="password_baru2">
                        <?= form_error('password_baru2', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>