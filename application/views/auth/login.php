<div class="container">
    <div class="card mb-3 col-md-9 col-sm-12 col-lg-8 mx-auto shadow mt-5">
        <div class="row g-0">
            <div class="col-md-4 parent-login">
                <!-- <img src="<?= base_url('assets/img-login/bg.jpg'); ?>" class="img-fluid rounded-start" alt="..."> -->
                <div class="rounded w-100 h-100 img-login" style="background-image: url('<?= base_url('assets/img-login/bg.jpg'); ?>');"></div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="h5 text-center mb-4 mt-2 fw-bold">Selamat Datang</div>
                    <?= $this->session->flashdata('flash'); ?>
                    <form action="<?= base_url('auth'); ?>" method="post">
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        <div class="mb-3">
                            <input type="text" class="form-control px-3 py-2 rounded-5" id="email" name="email" placeholder="Masukkan Email Anda...">
                            <?= form_error('email', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control px-3 py-2 rounded-5" id="password" name="password" placeholder="Masukkan Password Anda...">
                            <?= form_error('password', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-5 mt-2"><i class="fa-solid fa-right-to-bracket pe-2"></i>Login</button>
                        <hr>
                    </form>
                    <div class="text-center">
                        <a href="#" class="text-decoration-none lh-lg"><b>Lupa Password?</b></a>
                        <!-- <br>
                        <a href="#" class="text-decoration-none lh-lg">Buat Akun Baru!</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>