<?php
session_start();
require '../koneksi.php';

// Proteksi siswa
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') { 
    header('Location: ../login.php'); 
    exit; 
}

$idSiswa = $_SESSION['id_siswa'];

// Query data siswa
$siswaQuery = mysqli_query($koneksi, "
    SELECT * FROM tb_siswa WHERE id_siswa='$idSiswa'
");
$siswa = mysqli_fetch_assoc($siswaQuery);

if (!$siswa) {
    die('Data siswa tidak ditemukan');
}

// Query eskul yang diikuti siswa
$eskulQuery = mysqli_query($koneksi, "
    SELECT e.nama_eskul
    FROM tb_siswa_eskul se
    JOIN tb_eskul e ON se.id_eskul = e.id_eskul
    WHERE se.id_siswa = '$idSiswa'
");

// Query jadwal eskul siswa
$jadwalQuery = mysqli_query($koneksi, "
    SELECT j.hari, j.jam_mulai, j.jam_selesai, e.nama_eskul
    FROM tb_jadwal j
    JOIN tb_eskul e ON j.id_eskul = e.id_eskul
    JOIN tb_siswa_eskul se ON e.id_eskul = se.id_eskul
    WHERE se.id_siswa = '$idSiswa'
    ORDER BY FIELD(j.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), j.jam_mulai
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
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
                <i class="bi bi-person-heart"></i> Dashboard Siswa
            </span>
            <div>
                <span class="text-white">Halo,</span>
                <span class="text-white fw-bold ms-1">
                    <?= htmlspecialchars($siswa['nama_siswa']) ?>
                </span>
                <a href="../logout.php" class="btn btn-danger btn-sm ms-3">
                    Logout <i class="bi bi-door-open-fill"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- PROFIL SISWA -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <i class="bi bi-person-circle"></i> Data Siswa
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> <?= htmlspecialchars($siswa['nama_siswa']) ?></p>
                <p><strong>NISN:</strong> <?= $siswa['id_siswa'] ?? '-' ?></p>
                <p><strong>Kelas:</strong> <?= $siswa['kelas'] ?? '-' ?></p>
                <p><strong>Alamat:</strong> <?= $siswa['alamat'] ?? '-' ?></p>
            </div>
        </div>

        <!-- ESKUL -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-diagram-3-fill"></i> Ekstrakurikuler yang Diikuti
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($eskulQuery) > 0): ?>
                    <ul class="list-group">
                        <?php while ($e = mysqli_fetch_assoc($eskulQuery)): ?>
                            <li class="list-group-item">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <?= htmlspecialchars($e['nama_eskul']) ?>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted">Belum mengikuti ekstrakurikuler</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- JADWAL -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-light">
                <i class="bi bi-calendar-event-fill"></i> Jadwal Latihan
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
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
                                <td>
                                    <span class="badge bg-success">
                                        <?= $j['nama_eskul'] ?>
                                    </span>
                                </td>
                                <td><?= $j['hari'] ?></td>
                                <td><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Jadwal belum tersedia
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
