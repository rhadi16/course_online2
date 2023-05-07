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
    <h3 class="text-dark my-3 h3 text-center">My Profile!</h3>
    <div class="px-3">
        <div class="card mb-3 mx-auto h-auto col-lg-8 col-md-9 shadow">
            <div class="row g-0">
                <div class="col-md-5 col-sm-12">
                    <div class="img-profile w-100 h-100" style="background-image: url('<?= base_url('assets/img-profile/') . $profile['image']; ?>')"></div>
                </div>
                <div class="col-md-7 col-sm-12">
                    <div class="card-body">
                        <?= form_open_multipart('guru/edit'); ?>
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        <input type="hidden" name="id" value="<?= $profile['id']; ?>">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $account['email']; ?>">
                            <?= form_error('email', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $profile['nama']; ?>">
                            <?= form_error('nama', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                        </div>
                        <div class="mb-3">
                            <label for="asal" class="form-label">Asal</label>
                            <input type="text" class="form-control" id="asal" name="asal" value="<?= $profile['asal']; ?>">
                            <?= form_error('asal', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                        </div>
                        <div class="mb-3">
                            <label for="tglahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tglahir" name="tglahir" value="<?= $profile['tglahir']; ?>">
                            <?= form_error('tglahir', '<p class="m-0 form-text text-danger text-center">', '</p>'); ?>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Picture</label>
                            <input class="form-control p-1" type="file" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>