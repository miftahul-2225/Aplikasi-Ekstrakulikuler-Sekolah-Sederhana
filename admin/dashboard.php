<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }

        /* === CARD ANIMATION === */
        .menu-card {
            border-radius: 18px;
            text-decoration: none;
            color: inherit;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeUp 0.7s ease forwards;
            transition:
                transform 0.45s cubic-bezier(.4,0,.2,1),
                box-shadow 0.45s cubic-bezier(.4,0,.2,1);
        }

        .menu-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 18px 40px rgba(0,0,0,0.12);
        }

        /* Delay animasi tiap card */
        .menu-card:nth-child(1) { animation-delay: .1s; }
        .menu-card:nth-child(2) { animation-delay: .2s; }
        .menu-card:nth-child(3) { animation-delay: .3s; }
        .menu-card:nth-child(4) { animation-delay: .4s; }

        /* === ICON === */
        .menu-icon {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-bottom: 14px;
            transition:
                transform 0.45s cubic-bezier(.4,0,.2,1),
                box-shadow 0.45s cubic-bezier(.4,0,.2,1);
        }

        .menu-card:hover .menu-icon {
            transform: rotate(8deg) scale(1.15);
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        }

        /* === ANIMASI KEYFRAMES === */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        <span class="text-white">
            <?= $_SESSION['username'] ?? 'Admin'; ?>
            <a href="../landing_page.php" class="btn btn-danger ms-3">Logout</a>
        </span>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <h3 class="mb-1">Dashboard Admin</h3>
    <p class="text-muted mb-4">Menu manajemen data ekstrakurikuler di sekolah</p>

    <div class="row">

        <!-- Guru -->
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="guru_index.php" class="menu-card card shadow-sm border-0 text-center p-4">
                <div class="menu-icon bg-success mx-auto">
                    <i class="bi bi-person-badge fs-3"></i>
                </div>
                <h5 class="fw-bold">Data Guru</h5>
                <small class="text-muted">Kelola Guru Pembina</small>
            </a>
        </div>

        <!-- Siswa -->
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="siswa_index.php" class="menu-card card shadow-sm border-0 text-center p-4">
                <div class="menu-icon bg-warning mx-auto">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <h5 class="fw-bold">Data Siswa</h5>
                <small class="text-muted">Kelola Data Siswa</small>
            </a>
        </div>

        <!-- Eskul -->
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="eskul_index.php" class="menu-card card shadow-sm border-0 text-center p-4">
                <div class="menu-icon bg-primary mx-auto">
                    <i class="bi bi-collection fs-3"></i>
                </div>
                <h5 class="fw-bold">Data Eskul</h5>
                <small class="text-muted">Kelola Ekstrakurikuler</small>
            </a>
        </div>

        <!-- Jadwal -->
        <div class="col-md-3 col-sm-6 mb-4">
            <a href="jadwal_index.php" class="menu-card card shadow-sm border-0 text-center p-4">
                <div class="menu-icon bg-danger mx-auto">
                    <i class="bi bi-calendar-event-fill fs-3"></i>
                </div>
                <h5 class="fw-bold">Jadwal Eskul</h5>
                <small class="text-muted">Atur Jadwal Kegiatan</small>
            </a>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
