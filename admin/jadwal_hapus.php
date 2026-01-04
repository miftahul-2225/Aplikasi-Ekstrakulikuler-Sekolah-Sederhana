<?php
require '../koneksi.php';
$id = $_GET['id'];
mysqli_query ($koneksi, "
            DELETE FROM tb_jadwal WHERE id_jadwal = '$_GET[id]'");
header("Location: jadwal_index.php");
?>