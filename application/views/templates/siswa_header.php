<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $judul; ?></title>
    <!-- bootstrap 5 css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <!-- BOX ICONS CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Viga&display=swap" rel="stylesheet">
    <!-- custom css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/siswa-style.css'); ?>" />
</head>

<body>
    <!-- Side-Nav -->
    <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
        <ul class="nav d-flex flex-column text-white">
            <li class="nav-link w-100 text-center my-2">
                <div class="col-12 parent-profile w-50 mx-auto">
                    <div class="img-round-profile w-100 h-100 rounded-circle" style="background-image: url('<?= base_url('assets/img-profile/') . $profile['image']; ?>')"></div>
                </div>
                <div class="col-12 h3 mt-2">
                    <a href="<?= base_url('siswa'); ?>" class="text-white my-2 text-capitalize text-decoration-none fs-4">
                        <?= $profile['nama']; ?>
                    </a>
                </div>
            </li>
            <li class="nav-link p-0 <?php if ($judul == "Home") {
                                        echo "active";
                                    } ?>">
                <a href="<?= base_url('siswa'); ?>" class="text-decoration-none text-white w-100 d-inline-block px-3 py-2">
                    <i class="fas fa-home"></i>
                    <span class="mx-2">Home</span>
                </a>
            </li>
            <li class="nav-link p-0 <?php if ($judul == "My Profile") {
                                        echo "active";
                                    } ?>">
                <a href="<?= base_url('siswa/edit'); ?>" class="text-decoration-none text-white w-100 d-inline-block px-3 py-2">
                    <i class="fas fa-user-circle"></i>
                    <span class="mx-2">My Profile</span>
                </a>
            </li>
            <li class="nav-link p-0 <?php if ($judul == "Setting Password") {
                                        echo "active";
                                    } ?>">
                <a href="<?= base_url('siswa/settingpassword'); ?>" class="text-decoration-none text-white w-100 d-inline-block px-3 py-2">
                    <i class="fas fa-key"></i>
                    <span class="mx-2">Setting Password</span>
                </a>
            </li>
            <li class="nav-link p-0 <?php if ($judul == "Jadwal Kelas") {
                                        echo "active";
                                    } ?>">
                <a href="<?= base_url('siswa/jadwal_kelas'); ?>" class="text-decoration-none text-white w-100 d-inline-block px-3 py-2">
                    <i class="fa-solid fa-list"></i>
                    <span class="mx-2">Jadwal Kelas</span>
                </a>
            </li>
            <li class="nav-link p-0">
                <a class="text-decoration-none text-white w-100 d-inline-block px-3 py-2" id="logout">
                    <i class="fas fa-sign-out"></i>
                    <span class="mx-2">Logout</span>
                </a>
            </li>
        </ul>

        <span href="#" class="nav-link w-100 mb-5 p-2 ps-4">
            <a href="#insta" class="h4"><i class="fab fa-instagram text-white"></i></i></a>
            <a href="#github" class="mx-3 h4"><i class="fab fa-github text-white"></i></a>
            <a href="#facebook" class="h4"><i class="fab fa-facebook text-white"></i></a>
        </span>
    </div>