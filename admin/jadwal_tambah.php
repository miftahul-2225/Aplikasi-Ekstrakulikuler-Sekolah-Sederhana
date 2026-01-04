<?php
require '../koneksi.php';

$dataEskul = mysqli_query($koneksi,"SELECT * FROM tb_eskul");
$dataGuru  = mysqli_query($koneksi,"SELECT * FROM tb_guru");

if(isset($_POST['simpan'])){
    mysqli_query($koneksi,"
        INSERT INTO tb_jadwal 
        (id_eskul,id_guru,hari,jam_mulai,jam_selesai,tempat)
        VALUES (
            '$_POST[id_eskul]',
            '$_POST[id_guru]',
            '$_POST[hari]',
            '$_POST[jam_mulai]',
            '$_POST[jam_selesai]',
            '$_POST[tempat]'
        )
    ");
    header("Location: jadwal_index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Jadwal Eskul</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4 col-md-6">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5>Tambah Jadwal Eskul</h5>
            <form method="POST">

                <div class="mb-3">
                    <label>Ekstrakurikuler</label>
                    <select name="id_eskul" class="form-select" required>
                        <option value="">-- Pilih Eskul --</option>
                        <?php while($e=mysqli_fetch_assoc($dataEskul)): ?>
                            <option value="<?= $e['id_eskul'] ?>"><?= $e['nama_eskul'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Guru</label>
                    <select name="id_guru" class="form-select" required>
                        <option value="">-- Pilih Guru --</option>
                        <?php while($g=mysqli_fetch_assoc($dataGuru)): ?>
                            <option value="<?= $g['id_guru'] ?>"><?= $g['nama_guru'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Hari</label>
                    <select name="hari" class="form-select" required>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                    <div class="col">
                        <label>Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label>Tempat</label>
                    <input type="text" name="tempat" class="form-control" required>
                </div>
                <div class="text-end">
                    <a href="jadwal_index.php" class="btn btn-secondary">Batal</a>
                    <button name="simpan" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
