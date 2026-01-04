<?php
session_start();
require '../koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$query = mysqli_query($koneksi, "
    SELECT 
        j.id_jadwal,
        j.hari,
        j.jam_mulai,
        j.jam_selesai,
        e.nama_eskul,
        g.nama_guru,
        r.nama_role
    FROM tb_jadwal j
    JOIN tb_eskul e ON j.id_eskul = e.id_eskul
    JOIN tb_guru_eskul ge ON e.id_eskul = ge.id_eskul
    JOIN tb_guru g ON ge.id_guru = g.id_guru
    JOIN tb_role r ON ge.id_role = r.id_role
    ORDER BY j.hari, j.jam_mulai
");

if (!$query) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Jadwal Eskul</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            <i class="bi bi-calendar-event"></i> Jadwal Ekstrakurikuler
        </span>
        <a href="dashboard.php" class="btn btn-info btn-sm">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Data Jadwal Eskul</h4>
        <a href="jadwal_tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Ekstrakurikuler</th>
                        <th>Nama Guru</th>
                        <th>Role</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (mysqli_num_rows($query) > 0): ?>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <?= htmlspecialchars($row['nama_eskul']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['nama_guru']) ?></td>
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
                            <td><?= htmlspecialchars($row['hari']) ?></td>
                            <td>
                                <?= htmlspecialchars($row['jam_mulai']) ?> - <?= htmlspecialchars($row['jam_selesai']) ?>
                            </td>
                            <td class="text-center">
                                <a href="jadwal_edit.php?id=<?= $row['id_jadwal'] ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="jadwal_hapus.php?id=<?= $row['id_jadwal'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Hapus jadwal ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Jadwal belum tersedia
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
