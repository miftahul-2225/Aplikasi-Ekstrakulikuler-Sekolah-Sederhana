<?php
session_start();
require '../koneksi.php';

$id = $_GET['id_siswa'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE id_siswa='$id'"));

if (isset($_POST['update'])) {
    mysqli_query($koneksi, "
        UPDATE tb_siswa SET
        nama_siswa='$_POST[nama_siswa]',
        kelas='$_POST[kelas]',
        alamat='$_POST[alamat]',
        jenis_kelamin='$_POST[jenis_kelamin]'
        WHERE id_siswa='$id'
    ");
    header("Location: siswa_index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Siswa</title>

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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center">
                            <i class="bi bi-pencil-square"></i> Edit Siswa
                        </h4>
                        <form method="POST">
                            <input class="form-control mb-2" name="nama_siswa" value="<?= $data['nama_siswa'] ?>">
                            <input class="form-control mb-2" name="kelas" value="<?= $data['kelas'] ?>">
                            <select class="form-select mb-2" name="jenis_kelamin">
                                <option <?= $data['jenis_kelamin']=='Laki-Laki'?'selected':'' ?>>Laki-Laki</option>
                                <option <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
                            </select>
                            <textarea class="form-control mb-2" name="alamat"><?= $data['alamat'] ?></textarea>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="siswa_index.php" class="btn btn-secondary">Batal</a>
                                 <button name="update" class="btn btn-primary">Update</button>
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
