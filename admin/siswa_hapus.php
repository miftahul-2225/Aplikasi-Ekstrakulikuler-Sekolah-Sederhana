<?php
require '../koneksi.php';
$id = $_GET['id_siswa'];

mysqli_query($koneksi, "DELETE FROM tb_siswa WHERE id_siswa='$id'");
header("Location: siswa_index.php");
?>