<?php
session_start();
require "koneksi.php";

// Pastikan hanya guru yang boleh register
$role = isset($_GET['role']) ? $_GET['role'] : 'guru';

if ($role !== 'guru') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['register'])) {

    $id_guru   = mysqli_real_escape_string($koneksi, $_POST['id_guru']);
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
  

    // Cek ID guru
    $cek = mysqli_query($koneksi, "
        SELECT * FROM tb_guru WHERE id_guru='$id_guru'
    ");

    if (mysqli_num_rows($cek) > 0) {
        $error = "ID Guru sudah terdaftar!";
    } else {
        // Simpan guru
        $insert = mysqli_query($koneksi, "
            INSERT INTO tb_guru (id_guru, nama_guru, jenis_kelamin)
            VALUES ('$id_guru', '$nama', '$jenis_kelamin')
        ");

        if ($insert) {
            $success = "Registrasi guru berhasil! Silakan login menggunakan ID Guru.";
        } else {
            $error = "Registrasi gagal!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { min-height: 100vh; }
        .card { border-radius: 1rem; }
    </style>
</head>

<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        <div class="card shadow">

            <!-- HEADER -->
            <div class="card-header bg-primary text-white text-center py-3">
                <i class="bi bi-person-workspace fs-1"></i>
                <h4 class="mt-2 mb-0">Registrasi Guru</h4>
            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>

                <?php if (!empty($success)) { ?>
                    <div class="alert alert-success">
                        <?= $success ?><br>
                        <a href="login.php?role=guru" class="fw-semibold">
                            Login sekarang
                        </a>
                    </div>
                <?php } ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" name="id_guru" class="form-control" required>
                        <small class="text-muted">Digunakan sebagai username & password</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_guru" class="form-control" required>
                    </div>

                    <label for="jk">Pilih Jenis Kelamin</label>
                    <div class="mb-3 mt-1" id="jk">
                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-check-input" required> Laki-laki
                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-check-input ms-3" required> Perempuan
                    </div>

                    <div class="d-grid">
                        <button name="register" class="btn btn-primary fw-semibold">
                            <i class="bi bi-check-circle me-1"></i> Daftar
                        </button>
                    </div>

                </form>
            </div>

            <!-- FOOTER -->
            <div class="card-footer text-center small text-muted">
                © <?= date('Y') ?> Sistem Ekstrakurikuler Sekolah
            </div>

        </div>
    </div>
</div>
</body>
</html>
