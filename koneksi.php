<?php
$host = "localhost"; 
$user = "root";      
$pass = "";          
$db   = "db_eskul"; // Ganti dengan nama database Anda

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi){
    die("Koneksi Gagal " . mysqli_connect_error());
} 
?>
