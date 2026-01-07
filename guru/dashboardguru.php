<?php
session_start();
require '../koneksi.php';

// Proteksi guru
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header('Location: ../login.php');
    exit;
}

$idGuru = $_SESSION['id_guru'];

/* ===================== DATA GURU ===================== */
$guruQuery = mysqli_query($koneksi, "
    SELECT * FROM tb_guru WHERE id_guru='$idGuru'
");
$guru = mysqli_fetch_assoc($guruQuery);
if (!$guru) {
    die('Data guru tidak ditemukan');
}

/* ===================== ESKUL YANG DILATIH ===================== */
$eskulQuery = mysqli_query($koneksi, "
    SELECT DISTINCT e.id_eskul, e.nama_eskul, r.nama_role
    FROM tb_guru_eskul ge
    JOIN tb_eskul e ON ge.id_eskul = e.id_eskul
    JOIN tb_role r ON ge.id_role = r.id_role
    WHERE ge.id_guru='$idGuru'
");

/* ===================== JADWAL ===================== */
$jadwalQuery = mysqli_query($koneksi, "
    SELECT j.*, e.nama_eskul
    FROM tb_jadwal j
    JOIN tb_eskul e ON j.id_eskul = e.id_eskul
    JOIN tb_guru_eskul ge ON e.id_eskul = ge.id_eskul
    WHERE ge.id_guru='$idGuru'
    ORDER BY j.hari, j.jam_mulai
");

/* ===================== SISWA ===================== */
$siswaQuery = mysqli_query($koneksi, "
    SELECT DISTINCT s.id_siswa, s.nama_siswa, e.nama_eskul
    FROM tb_siswa_eskul se
    JOIN tb_siswa s ON se.id_siswa = s.id_siswa
    JOIN tb_eskul e ON se.id_eskul = e.id_eskul
    JOIN tb_guru_eskul ge ON e.id_eskul = ge.id_eskul
    WHERE ge.id_guru='$idGuru'
    ORDER BY s.nama_siswa
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
<!-- NAVBAR -->
    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-person-badge"></i> Dashboard Guru
            </span>
            <div>
            <span class="text-white">Halo</span>
            <span class="text-white fw-bold ms-1">
                <?= htmlspecialchars($guru['nama_guru']) ?>
            </span>
            <a href="../logout.php" class="btn btn-danger btn-sm ms-3">
                Logout <i class="bi bi-door-open-fill"></i>
            </a>
            </div>
        </div>
    </nav>

<div class="container mt-4">
    <!-- ESKUL -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-success text-white">
            <i class="bi bi-diagram-3"></i> Ekstrakurikuler yang Dilatih
        </div>
        <div class="card-body">
            <?php if (mysqli_num_rows($eskulQuery) > 0): ?>
                <ul class="list-group">
                    <?php while ($e = mysqli_fetch_assoc($eskulQuery)): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= htmlspecialchars($e['nama_eskul']) ?>
                            <span class="badge bg-info text-dark">
                                <?= $e['nama_role'] ?>
                            </span>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Belum ditugaskan ke eskul manapun</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- JADWAL -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning">
            <i class="bi bi-calendar-event"></i> Jadwal Latihan
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Eskul</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($jadwalQuery) > 0): ?>
                    <?php while ($j = mysqli_fetch_assoc($jadwalQuery)): ?>
                        <tr>
                            <td><?= $j['nama_eskul'] ?></td>
                            <td><?= $j['hari'] ?></td>
                            <td><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada jadwal</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SISWA -->
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            <i class="bi bi-people-fill"></i> Siswa yang Dibina
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Eskul</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($siswaQuery) > 0): ?>
                    <?php while ($s = mysqli_fetch_assoc($siswaQuery)): ?>
                        <tr>
                            <td><?= htmlspecialchars($s['nama_siswa']) ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <?= $s['nama_eskul'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center text-muted">
                            Belum ada siswa terdaftar
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    
</body>
</html>
