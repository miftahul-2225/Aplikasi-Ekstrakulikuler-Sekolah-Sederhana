<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

// Ambil data Eskul
$dataEskul = mysqli_query($koneksi, "
    SELECT * FROM tb_eskul ORDER BY nama_eskul ASC
");

// Simpan data
if (isset($_POST['simpan'])) {
    $nama_eskul = $_POST['nama_eskul'];

    // Cek duplikasi eskul
    $cek = mysqli_query($koneksi, "
        SELECT 1 FROM tb_eskul
        WHERE nama_eskul='$nama_eskul'
    ");

    if (!$cek) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    if (mysqli_num_rows($cek) > 0) {
        $error = "Eskul dengan nama tersebut sudah ada.";
    } else {

        // Simpan
        $insert = mysqli_query($koneksi, "
            INSERT INTO tb_eskul (nama_eskul)
            VALUES ('$nama_eskul')
        ");

        if (!$insert) {
            die("Insert Error: " . mysqli_error($koneksi));
        } else {
            header('Location: eskul_index.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Eskul Baru</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">  

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> 
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            <i class="bi bi-person-plus-fill"></i> Tambah Eskul Baru
        </span>
    </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <h4 class="text-center">Form Tambah Eskul Baru</h4>
                            <div class="mb-3">
                                <label for="nama_eskul" class="form-label">Nama Eskul</label>
                                <input type="text" class="form-control" id="nama_eskul" name="nama_eskul" required>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="eskul_index.php" class="btn btn-secondary">Batal</a>
                                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>