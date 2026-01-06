<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id_eskul'])) {
    header('Location: eskul_index.php');
    exit;
}

$id_eskul = intval($_GET['id_eskul']);

$data = mysqli_query($koneksi, "SELECT * FROM tb_eskul WHERE id_eskul = $id_eskul");
$eskul = mysqli_fetch_assoc($data);

if (!$eskul) {
    die('Data eskul tidak ditemukan');
}

if (isset($_POST['simpan'])) {
    $nama_eskul = mysqli_real_escape_string($koneksi, $_POST['nama_eskul']);

    $update = mysqli_query($koneksi, "
        UPDATE tb_eskul SET
        nama_eskul = '$nama_eskul'
        WHERE id_eskul = $id_eskul
    ");

    if ($update) {
        header('Location: eskul_index.php?status=edit_sukses');
        exit;
    } else {
        die('Update gagal: ' . mysqli_error($koneksi));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Eskul</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            <i class="bi bi-pencil-square"></i> Edit Data Eskul
        </span>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-3 text-center">
                        <i class="bi bi-pencil-square"></i> Edit Data Eskul
                    </h4>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Eskul</label>
                            <input type="text" name="nama_eskul" class="form-control"
                                   value="<?= htmlspecialchars($eskul['nama_eskul']); ?>" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="eskul_index.php" class="btn btn-secondary">Batal</a>
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

</body>
</html>
