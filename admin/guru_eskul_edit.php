<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$id_guru  = $_GET['id_guru'];
$id_eskul = $_GET['id_eskul'];

// Ambil data lama
$data = mysqli_query($koneksi, "
    SELECT ge.*, g.nama_guru, e.nama_eskul
    FROM tb_guru_eskul ge
    JOIN tb_guru g ON ge.id_guru = g.id_guru
    JOIN tb_eskul e ON ge.id_eskul = e.id_eskul
    WHERE ge.id_guru = '$id_guru'
    AND ge.id_eskul = '$id_eskul'
");

$row = mysqli_fetch_assoc($data);

// Ambil role
$role = mysqli_query($koneksi, "SELECT * FROM tb_role");

// Ambil eskul
$eskul = mysqli_query($koneksi, "SELECT * FROM tb_eskul");

// Proses update
if (isset($_POST['simpan'])) {
    $id_role_baru  = $_POST['id_role'];
    $id_eskul_baru = $_POST['id_eskul'];

    $update = mysqli_query($koneksi, "
        UPDATE tb_guru_eskul SET
        id_role = '$id_role_baru',
        id_eskul = '$id_eskul_baru'
        WHERE id_guru = '$id_guru'
        AND id_eskul = '$id_eskul'
    ");

    if ($update) {
        header('Location: guru_index.php?status=edit_sukses');
        exit;
    } else {
        echo "Update gagal: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Edit Guru Eskul</title>
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
                    <i class="bi bi-person-lines-fill"></i> Edit Guru Eskul
                </span>
            </div>
        </nav>

            <div class="container mt-4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form method="POST">
                                    <h4 class="text-center">Edit Data Guru Eskul</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Guru</label>
                                        <input type="text" class="form-control" value="<?= $row['nama_guru'] ?>" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Ekstrakurikuler</label>
                                        <select name="id_eskul" class="form-select" required>
                                            <?php while ($e = mysqli_fetch_assoc($eskul)): ?>
                                                <option value="<?= $e['id_eskul'] ?>"
                                                    <?= $e['id_eskul'] == $row['id_eskul'] ? 'selected' : '' ?>>
                                                    <?= $e['nama_eskul'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <select name="id_role" class="form-select" required>
                                            <?php while ($r = mysqli_fetch_assoc($role)): ?>
                                                <option value="<?= $r['id_role'] ?>"
                                                    <?= $r['id_role'] == $row['id_role'] ? 'selected' : '' ?>>
                                                    <?= $r['nama_role'] ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
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
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
