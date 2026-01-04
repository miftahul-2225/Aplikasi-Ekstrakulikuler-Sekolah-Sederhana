<?php
// Koneksi database
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Simpan data
if (isset($_POST['simpan'])) {
    $namaguru = $_POST['namaguru'];
    $jeniskelamin = $_POST['jeniskelamin'];

    // Simpan
    $insert = mysqli_query($koneksi, "
        INSERT INTO tb_guru (nama_guru, jenis_kelamin)
        VALUES ('$namaguru', '$jeniskelamin')
    ");

    if (!$insert) {
        die("Insert Error: " . mysqli_error($koneksi));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Guru Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
           <i class="bi bi-person-plus-fill"></i> Tambah Guru Baru
        </span>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <h4 class="text-center">Form Tambah Guru Baru </h4>
                        
                        <!-- Nama Guru -->
                        <div class="mb-3">
                            <label for="namaguru">Nama Lengkap</label>
                            <input type="text" class="form-control mt-2" id="nama-guru" name="namaguru" required placeholder="Masukkan Nama Lengkap Guru">
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="mb-3">
                            <label for="jeniskelamin">Jenis Kelamin</label>
                            <select class="form-select mt-2 mb-2" id="jenis-kelamin" name="jeniskelamin" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="guru_index.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="simpan" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
