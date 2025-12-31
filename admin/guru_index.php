<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Query data guru eskul + role
$query = mysqli_query($koneksi, "
    SELECT 
        ge.id_guru,
        ge.id_eskul,
        r.nama_role,
        g.nama_guru,
        g.jenis_kelamin,
        e.nama_eskul
    FROM tb_guru_eskul ge
    JOIN tb_guru g ON ge.id_guru = g.id_guru
    JOIN tb_eskul e ON ge.id_eskul = e.id_eskul
    JOIN tb_role r ON ge.id_role = r.id_role
    ORDER BY g.nama_guru ASC
");

if (!$query) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Guru Eskul</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .table-hover tbody tr {
            transition: all .25s ease;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }
    </style>
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
            <h3 class="mb-0">Data Guru Ekstrakurikuler</h3>
            <small class="text-muted">Guru Pembina & Pelatih Eskul</small>
        </div>
        <div class="d-flex gap-2">
        <a href="guru_eskul_tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Guru Eskul
        </a>
        <a href="guru_index2.php" class="btn btn-success">
            <i class="bi bi-people-fill"></i> Lihat Data Guru
        </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Guru</th>
                            <th>Jenis Kelamin</th>
                            <th>Ekstrakurikuler</th>
                            <th>Role</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_guru']) ?></td>
                                <td>
                                    <?php if ($row['jenis_kelamin'] == 'Laki-Laki'): ?>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-gender-male"></i> Laki-Laki
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-gender-female"></i> Perempuan
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        <?= htmlspecialchars($row['nama_eskul']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['nama_role'] == 'Pembina'): ?>
                                        <span class="badge bg-info text-dark">
                                            <i class="bi bi-person-badge"></i> Pembina
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-person-standing"></i> Pelatih
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="guru_eskul_edit.php?id_guru=<?= $row['id_guru'] ?>&id_eskul=<?= $row['id_eskul'] ?>"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="guru_eskul_hapus.php?id_guru=<?= $row['id_guru'] ?>&id_eskul=<?= $row['id_eskul'] ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Data guru eskul belum tersedia
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
