<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}
// Query semua data eskul

$eskul = mysqli_query($koneksi, 
"SELECT * FROM tb_eskul ORDER BY id_eskul DESC");

if (!$eskul) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Ekstrakulikuler</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            <i class="bi bi-people-fill"></i> Admin Eskul
        </span>
        <a href="dashboard.php" class="btn btn-danger btn-sm">
            Kembali <i class="bi bi-door-open-fill"></i>
        </a>
    </div>
    </nav>

    <!-- CONTENT -->
    <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Data Ekstrakurikuler</h3>
            <small class="text-muted">Data kegiatan ekstrakurikuler yang tersedia</small>
        </div>
        <a href="eskul_tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Eskul Baru
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Eskul</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($eskul)) {
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_eskul']); ?></td>
                        <td class="text-center">
                            <a href="eskul_edit.php?id=<?= $row['id_eskul']; ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            <a href="eskul_hapus.php?id=<?= $row['id_eskul']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Yakin ingin menghapus eskul ini?');">
                                <i class="bi bi-trash-fill"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
