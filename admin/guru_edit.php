<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id_guru'])) {
    header('Location: guru_index2.php');
    exit;
}

$id_guru = intval($_GET['id_guru']);

// Ambil data guru
$data = mysqli_query($koneksi, "
    SELECT * FROM tb_guru WHERE id_guru = $id_guru
");

$guru = mysqli_fetch_assoc($data);

// Simpan perubahan
if (isset($_POST['simpan'])) {
    $nama_guru     = mysqli_real_escape_string($koneksi, $_POST['nama_guru']);
    $jenis_kelamin = $_POST['jenis_kelamin'];

    $update = mysqli_query($koneksi, "
        UPDATE tb_guru SET
        nama_guru = '$nama_guru',
        jenis_kelamin = '$jenis_kelamin'
        WHERE id_guru = $id_guru
    ");

    if ($update) {
        header('Location: guru_index2.php?status=edit_sukses');
        exit;
    } else {
        die('Update gagal: ' . mysqli_error($koneksi));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
           <i class="bi bi-person-lines-fill"></i> Edit Data Guru
        </span>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h4 class="mb-3 text-center">
                <i class="bi bi-pencil-square"></i> Edit Data Guru
            </h4>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-control"
                           value="<?= htmlspecialchars($guru['nama_guru']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="Laki-Laki" <?= $guru['jenis_kelamin']=='Laki-Laki'?'selected':'' ?>>
                            Laki-Laki
                        </option>
                        <option value="Perempuan" <?= $guru['jenis_kelamin']=='Perempuan'?'selected':'' ?>>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="guru_index2.php" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" name="simpan" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
