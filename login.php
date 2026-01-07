<?php
session_start();
require "koneksi.php";

// role dari landing page (login.php?role=siswa)
$roleDipilih = isset($_GET['role']) ? $_GET['role'] : '';

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $roleForm = $_POST['role'];

    if ($roleForm == "") {
        $error = "Silakan pilih role terlebih dahulu dari halaman utama!";
    }

    /* Login Admin */
    elseif ($roleForm == "admin") {

        $query = mysqli_query($koneksi, "
            SELECT * FROM users 
            WHERE username='$username' AND role='admin'
        ");

        $data = mysqli_fetch_assoc($query);

        if ($data && $password == $data['password']) {

            $_SESSION['role']    = 'admin';
            $_SESSION['id_user'] = $data['id_user'];

            header("Location: admin/dashboard.php");
            exit;
        } else {
            $error = "Username atau password admin salah!";
        }

    }

    /* Login Guru */
    elseif ($roleForm == "guru") {

        // login pakai ID GURU
        $query = mysqli_query($koneksi, "
            SELECT * FROM tb_guru 
            WHERE id_guru='$username'
        ");

        $data = mysqli_fetch_assoc($query);

        if ($data && $password == $data['id_guru']) {

            $_SESSION['role']    = 'guru';
            $_SESSION['id_guru'] = $data['id_guru'];

            header("Location: guru/dashboardguru.php");
            exit;
        } else {
            $error = "ID Guru tidak valid!";
        }

    }

    /* Login Siswa*/
    elseif ($roleForm == "siswa") {

        // login pakai ID SISWA
        $query = mysqli_query($koneksi, "
            SELECT * FROM tb_siswa 
            WHERE id_siswa='$username'
        ");

        $data = mysqli_fetch_assoc($query);

        if ($data && $password == $data['id_siswa']) {

            $_SESSION['role']     = 'siswa';
            $_SESSION['id_siswa'] = $data['id_siswa'];

            header("Location: siswa/dashboardsiswa.php");
            exit;
        } else {
            $error = "ID Siswa tidak valid!";
        }

    }
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Sistem Eskul</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* background: linear-gradient(135deg, #0d6efd, #6f42c1); */
        body {
            min-height: 100vh;
        }
        .login-card {
            border-radius: 1rem;
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-4 col-sm-10">
            <div class="card shadow-lg login-card">
                <!-- HEADER -->
                <div class="card-header login-header text-white text-center py-4">
                    <i class="bi bi-shield-lock fs-1"></i>
                    <h4 class="mt-2 mb-0 fw-bold">Login Sistem Eskul</h4>
                    <small class="opacity-75">Akses sesuai role pengguna</small>
                </div>

                <!-- BODY -->
                <div class="card-body p-4">
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $error ?>
                        </div>
                    <?php } ?>

                    <form method="POST">
                        <!-- Hidden role -->
                        <input type="hidden" name="role" value="<?= $roleDipilih ?>">

                        <?php if ($roleDipilih != "") { ?>
                            <div class="alert alert-info text-center py-2">
                                Login sebagai <strong><?= strtoupper($roleDipilih) ?></strong>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-warning text-center">
                                <i class="bi bi-info-circle"></i><br>
                                Silakan pilih role terlebih dahulu dari halaman utama
                            </div>
                        <?php } ?>

                        <!-- USERNAME -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-person-fill"></i>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <!-- PASSWORD -->
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <button class="btn btn-primary w-100 py-2 fw-semibold" name="login">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </button>

                    </form>
                </div>

                <!-- FOOTER -->
                <div class="card-footer text-center small text-muted">
                    © <?= date('Y') ?> Sistem Ekstrakurikuler Sekolah
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
