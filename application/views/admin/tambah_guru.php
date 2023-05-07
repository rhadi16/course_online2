<div class="container pt-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow">
                <h5 class="card-header text-center">Form Tambah Guru</h5>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                        <div class="mb-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="id" name="id" value="<?= $input['id']; ?>">
                            <div class="form-text text-danger"><?= form_error('id'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $input['nama']; ?>">
                            <div class="form-text text-danger"><?= form_error('nama'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="asal" class="form-label">Asal Kota</label>
                            <input type="text" class="form-control" id="asal" name="asal" value="<?= $input['asal']; ?>">
                            <div class="form-text text-danger"><?= form_error('asal'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="tglahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tglahir" name="tglahir" value="<?= $input['tglahir']; ?>">
                            <div class="form-text text-danger"><?= form_error('tglahir'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $input['email']; ?>">
                            <div class="form-text text-danger"><?= form_error('email'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div class="form-text text-danger"><?= form_error('password'); ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="password2" class="form-label">Repeat Password</label>
                            <input type="password" class="form-control" id="password2" name="password2">
                            <div class="form-text text-danger"><?= form_error('password2'); ?></div>
                        </div>
                        <div class="mb-3">
                            <?php foreach ($mapel as $m) : ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="<?= $m['id']; ?>" id="mapel<?= $m['id']; ?>" name="mapel[]">
                                    <label class="form-check-label" for="mapel<?= $m['id']; ?>">
                                        <?= $m['nama_mapel']; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                        <a href="<?= base_url('admin/guru'); ?>" class="btn btn-danger mx-2 float-end">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>