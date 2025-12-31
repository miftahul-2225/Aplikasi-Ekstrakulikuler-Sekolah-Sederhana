<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$query = mysqli_query($koneksi, "
    SELECT 
        se.id_siswa,
        se.id_eskul,
        s.nama_siswa,
        s.kelas,
        s.jenis_kelamin,
        e.nama_eskul
    FROM tb_siswa_eskul se
    JOIN tb_siswa s ON se.id_siswa = s.id_siswa
    JOIN tb_eskul e ON se.id_eskul = e.id_eskul
    ORDER BY s.nama_siswa ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa Eskul</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .table-hover tbody tr {
            transition: .25s;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }
    </style>
</head>
<body>

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

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">Data Siswa Ekstrakurikuler</h3>
            <small class="text-muted">Keikutsertaan siswa dalam eskul</small>
        </div>
        <div class="d-flex gap-2">
        <a href="siswa_eskul_tambah.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Siswa Eskul
        </a>
            <a href="siswa_index.php" class="btn btn-success">
                Data Siswa <i class="bi bi-people-fill"></i>
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Ekstrakurikuler</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($query) > 0): ?>
                        <?php $no=1; while($row=mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td><?= htmlspecialchars($row['kelas']) ?></td>
                            <td>
                                <?php if ($row['jenis_kelamin']=='Laki-Laki'): ?>
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
                            <td class="text-center">
                                <a href="siswa_eskul_edit.php?id_siswa=<?= $row['id_siswa'] ?>&id_eskul=<?= $row['id_eskul'] ?>"
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="siswa_eskul_hapus.php?id_siswa=<?= $row['id_siswa'] ?>&id_eskul=<?= $row['id_eskul'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Data siswa eskul belum tersedia
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</body>
</html>
