<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role']!='admin') {
    header('Location: ../login.php');
    exit;
}

$dataSiswa = mysqli_query($koneksi,"SELECT * FROM tb_siswa ORDER BY nama_siswa");
$dataEskul = mysqli_query($koneksi,"SELECT * FROM tb_eskul ORDER BY nama_eskul");

if (isset($_POST['simpan'])) {
    $id_siswa = $_POST['id_siswa'];
    $id_eskul = $_POST['id_eskul'];

    $cek = mysqli_query($koneksi,"
        SELECT * FROM tb_siswa_eskul
        WHERE id_siswa='$id_siswa' AND id_eskul='$id_eskul'
    ");

    if (mysqli_num_rows($cek)>0) {
        $error = "Siswa sudah terdaftar di eskul ini.";
    } else {
        mysqli_query($koneksi,"
            INSERT INTO tb_siswa_eskul (id_siswa,id_eskul)
            VALUES ('$id_siswa','$id_eskul')
        ");
        header("Location: siswa_eskul_index.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Siswa Eskul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Tambah Siswa Eskul</h5>

            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label>Siswa</label>
                    <select name="id_siswa" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php while($s=mysqli_fetch_assoc($dataSiswa)): ?>
                            <option value="<?= $s['id_siswa'] ?>">
                                <?= $s['nama_siswa'] ?> (<?= $s['kelas'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Ekstrakurikuler</label>
                    <select name="id_eskul" class="form-select" required>
                        <option value="">-- Pilih Eskul --</option>
                        <?php while($e=mysqli_fetch_assoc($dataEskul)): ?>
                            <option value="<?= $e['id_eskul'] ?>">
                                <?= $e['nama_eskul'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="text-end">
                    <a href="siswa_eskul_index.php" class="btn btn-secondary">Batal</a>
                    <button name="simpan" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
