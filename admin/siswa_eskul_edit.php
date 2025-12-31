<?php
require '../koneksi.php';

$id_siswa = $_GET['id_siswa'];
$id_eskul = $_GET['id_eskul'];

$dataEskul = mysqli_query($koneksi,"SELECT * FROM tb_eskul");

if (isset($_POST['update'])) {
    mysqli_query($koneksi,"
        UPDATE tb_siswa_eskul
        SET id_eskul='$_POST[id_eskul]'
        WHERE id_siswa='$id_siswa'
    ");
    header("Location: siswa_eskul_index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa Eskul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 col-md-6">
    <form method="POST">
        <label>Ekstrakurikuler</label>
        <select name="id_eskul" class="form-select mb-3">
            <?php while($e=mysqli_fetch_assoc($dataEskul)): ?>
                <option value="<?= $e['id_eskul'] ?>">
                    <?= $e['nama_eskul'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button name="update" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>
