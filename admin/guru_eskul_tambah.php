<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Ambil data guru
$dataGuru = mysqli_query($koneksi, "
    SELECT * FROM tb_guru ORDER BY nama_guru ASC
");

// Ambil data eskul
$dataEskul = mysqli_query($koneksi, "
    SELECT * FROM tb_eskul ORDER BY nama_eskul ASC
");

// Ambil role (HANYA 1 Pembina & 1 Pelatih)
$dataRole = mysqli_query($koneksi, "
    SELECT MIN(id_role) AS id_role, nama_role
    FROM tb_role
    WHERE nama_role IN ('Pembina', 'Pelatih')
    GROUP BY nama_role
");

// Simpan data
if (isset($_POST['simpan'])) {
    $id_guru  = $_POST['id_guru'];
    $id_eskul = $_POST['id_eskul'];
    $id_role  = $_POST['id_role'];

    // Cek duplikasi guru + eskul + role
    $cek = mysqli_query($koneksi, "
        SELECT 1 FROM tb_guru_eskul
        WHERE id_guru='$id_guru'
          AND id_eskul='$id_eskul'
          AND id_role='$id_role'
    ");

    if (!$cek) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($cek) > 0) {
        $error = "Guru dengan role tersebut sudah terdaftar di eskul ini.";
    } else {

        // Simpan
        $insert = mysqli_query($koneksi, "
            INSERT INTO tb_guru_eskul (id_guru, id_eskul, id_role)
            VALUES ('$id_guru', '$id_eskul', '$id_role')
        ");

        if (!$insert) {
            die("Insert Error: " . mysqli_error($koneksi));
        }

        header("Location: guru_index.php?status=success");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Guru Eskul</title>
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
            <i class="bi bi-person-lines-fill"></i> Tambah Guru Eskul
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
                        <h4 class="text-center">Form Penugasan Guru Eskul</h4>
                        <!-- Guru -->
                        <div class="mb-3">
                            <label class="form-label">Guru</label>
                            <select name="id_guru" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php while ($g = mysqli_fetch_assoc($dataGuru)): ?>
                                    <option value="<?= $g['id_guru'] ?>">
                                        <?= htmlspecialchars($g['nama_guru']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Eskul -->
                        <div class="mb-3">
                            <label class="form-label">Ekstrakurikuler</label>
                            <select name="id_eskul" class="form-select" required>
                                <option value="">-- Pilih Eskul --</option>
                                <?php while ($e = mysqli_fetch_assoc($dataEskul)): ?>
                                    <option value="<?= $e['id_eskul'] ?>">
                                        <?= htmlspecialchars($e['nama_eskul']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="id_role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <?php while ($r = mysqli_fetch_assoc($dataRole)): ?>
                                    <option value="<?= $r['id_role'] ?>">
                                        <?= htmlspecialchars($r['nama_role']) ?>
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

</body>
</html>
