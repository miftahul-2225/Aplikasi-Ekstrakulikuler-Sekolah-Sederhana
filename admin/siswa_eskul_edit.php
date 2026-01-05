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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa Eskul</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-person-lines-fill"></i> Edit Data Siswa Eskul
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="POST">
                        <h4 class="mb-3 text-center">
                            <i class="bi bi-pencil-square"></i> Edit Data Siswa Eskul
                        </h4>
                        <label>Ekstrakurikuler</label>
                        <select name="id_eskul" class="form-select mb-3">
                            <?php while($e=mysqli_fetch_assoc($dataEskul)): ?>
                                <option value="<?= $e['id_eskul'] ?>">
                                    <?= $e['nama_eskul'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="siswa_eskul_index.php" class="btn btn-secondary">Batal</a>
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
