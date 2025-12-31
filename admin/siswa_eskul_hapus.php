<?php
require '../koneksi.php';

$id_siswa = $_GET ['id_siswa'];
$id_eskul = $_GET ['id_eskul'];

mysqli_query($koneksi, "
        DELETE FROM tb_siswa_eskul
        WHERE id_siswa = '$id_siswa' AND id_eskul = '$id_eskul'
");

header("Location: siswa_eskul_index.php")
?>