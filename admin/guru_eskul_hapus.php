<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Validasi parameter
if (!isset($_GET['id_guru']) || !isset($_GET['id_eskul'])) {
    header('Location: guru_index.php');
    exit;
}

$id_guru  = intval($_GET['id_guru']);
$id_eskul = intval($_GET['id_eskul']);

// Hapus data
$hapus = mysqli_query($koneksi, "
    DELETE FROM tb_guru_eskul 
    WHERE id_guru = $id_guru 
    AND id_eskul = $id_eskul
");

if ($hapus) {
    header('Location: guru_index.php?status=hapus_sukses');
} else {
    die('Hapus gagal: ' . mysqli_error($koneksi));
}
