<?php
session_start();
require '../koneksi.php';
if ($_SESSION['role'] != 'siswa') { header('Location: ../login.php'); exit; }

include '../layout_dashboard.php';
?>

<h3>Dashboard Siswa</h3>
<p>Selamat datang, <?= $_SESSION['nama'] ?></p>
<div class="card p-3 mt-3">
    <h5>Eskul yang Anda ikuti:</h5>
    <ul>
        <?php
        $idSiswa = $_SESSION['id_user'];
        $q = mysqli_query($koneksi, "
            SELECT e.nama_eskul
            FROM tb_pendaftaran p
            JOIN tb_eskul e ON p.id_eskul = e.id_eskul
            WHERE p.id_siswa = '$idSiswa'
        ");
        while ($d = mysqli_fetch_assoc($q)) {
            echo "<li>".$d['nama_eskul']."</li>";
        }
        ?>
    </ul>
</div>  