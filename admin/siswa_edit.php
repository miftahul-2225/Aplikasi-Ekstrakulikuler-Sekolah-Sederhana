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
    <title>Edit Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4 col-md-6">
    <h4>Edit Siswa</h4>
    <form method="POST">
        <input class="form-control mb-2" name="nama_siswa" value="<?= $data['nama_siswa'] ?>">
        <input class="form-control mb-2" name="kelas" value="<?= $data['kelas'] ?>">
        <select class="form-select mb-2" name="jenis_kelamin">
            <option <?= $data['jenis_kelamin']=='Laki-Laki'?'selected':'' ?>>Laki-Laki</option>
            <option <?= $data['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
        </select>
        <textarea class="form-control mb-2" name="alamat"><?= $data['alamat'] ?></textarea>
        <button name="update" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
