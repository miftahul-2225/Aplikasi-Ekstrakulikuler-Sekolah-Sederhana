<?php
session_start();
require "koneksi.php";

// Pastikan hanya siswa yang boleh register
$role = isset($_GET['role']) ? $_GET['role'] : 'siswa';

if ($role !== 'siswa') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['register'])) {

    $id_siswa   = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
    $nama       = mysqli_real_escape_string($koneksi, $_POST['nama_siswa']);
    $kelas      = mysqli_real_escape_string($koneksi, $_POST['kelas']);
    $alamat     = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);

    // Cek apakah ID sudah terdaftar
    $cek = mysqli_query($koneksi, "
        SELECT * FROM tb_siswa WHERE id_siswa='$id_siswa'
    ");

    if (mysqli_num_rows($cek) > 0) {
        $error = "ID Siswa sudah terdaftar!";
    } else {
        // Simpan data siswa
        $insert = mysqli_query($koneksi, "
            INSERT INTO tb_siswa (id_siswa, nama_siswa, kelas, alamat, jenis_kelamin)
            VALUES ('$id_siswa', '$nama', '$kelas', '$alamat', '$jenis_kelamin')
        ");

        if ($insert) {
            $success = "Registrasi berhasil! Silakan login menggunakan ID Siswa.";
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
    <title>Register Siswa</title>
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
                <i class="bi bi-person-plus fs-1"></i>
                <h4 class="mt-2 mb-0">Registrasi Siswa</h4>
            </div>

            <!-- BODY -->
            <div class="card-body p-4">

                <?php if (!empty($error)) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>

                <?php if (!empty($success)) { ?>
                    <div class="alert alert-success">
                        <?= $success ?><br>
                        <a href="login.php?role=siswa" class="fw-semibold">Login sekarang</a>
                    </div>
                <?php } ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="id_siswa" class="form-control" required>
                        <small class="text-muted">Digunakan sebagai username & password</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_siswa" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="X PPLG 2" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
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
