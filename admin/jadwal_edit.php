<?php
session_start();
require '../koneksi.php';

// Proteksi admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit;
}

$id = $_GET['id'];

// Ambil data jadwal
$data = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM tb_jadwal WHERE id_jadwal='$id'")
);

// Ambil data eskul
$dataEskul = mysqli_query($koneksi, "SELECT * FROM tb_eskul ORDER BY nama_eskul ASC");

// Update data
if (isset($_POST['update'])) {
    $id_eskul   = $_POST['id_eskul'];
    $hari       = $_POST['hari'];
    $jam_mulai  = $_POST['jam_mulai'];
    $jam_selesai= $_POST['jam_selesai'];

    mysqli_query($koneksi, "
        UPDATE tb_jadwal SET
            id_eskul   = '$id_eskul',
            hari       = '$hari',
            jam_mulai  = '$jam_mulai',
            jam_selesai= '$jam_selesai'
        WHERE id_jadwal = '$id'
    ") or die(mysqli_error($koneksi));

    header("Location: jadwal_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Jadwal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">Edit Jadwal Eskul</h5>

            <form method="POST">

                <!-- Eskul -->
                <label class="form-label">Ekstrakurikuler</label>
                <select name="id_eskul" class="form-select mb-3" required>
                    <?php while ($e = mysqli_fetch_assoc($dataEskul)): ?>
                        <option value="<?= $e['id_eskul'] ?>"
                            <?= $e['id_eskul'] == $data['id_eskul'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['nama_eskul']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <!-- Hari -->
                <label class="form-label">Hari</label>
                <input type="text" name="hari" class="form-control mb-3"
                       value="<?= htmlspecialchars($data['hari']) ?>" required>

                <!-- Jam -->
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control"
                               value="<?= $data['jam_mulai'] ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control"
                               value="<?= $data['jam_selesai'] ?>" required>
                    </div>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="jadwal_index.php" class="btn btn-secondary">Batal</a>
                    <button name="update" class="btn btn-primary">
                        Update Jadwal
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

</body>
</html>
