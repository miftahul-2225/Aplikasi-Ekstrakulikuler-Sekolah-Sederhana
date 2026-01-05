<?php
session_start();
require '../koneksi.php';
mysqli_query($koneksi,
"DELETE FROM tb_eskul WHERE id_eskul='$_GET[id]'") or die(mysqli_error($koneksi));
header("Location:eskul_index.php");
?>