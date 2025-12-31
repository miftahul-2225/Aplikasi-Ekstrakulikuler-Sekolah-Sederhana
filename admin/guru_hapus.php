<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

if (!isset($_GET['id_guru'])) {
    header('Location: guru_index2.php');
    exit;
}

$id_guru = intval($_GET['id_guru']);

// Hapus relasi guru di eskul (PENTING)
mysqli_query($koneksi, "
    DELETE FROM tb_guru_eskul WHERE id_guru = $id_guru
");

// Hapus data guru
$hapus = mysqli_query($koneksi, "
    DELETE FROM tb_guru WHERE id_guru = $id_guru
");

if ($hapus) {
    header('Location: guru_index2.php?status=hapus_sukses');
} else {
    die('Hapus gagal: ' . mysqli_error($koneksi));
}
