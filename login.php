<?php
session_start();
require "koneksi.php";

// Ambil role dari URL landing page, misalnya login.php?role=siswa
$roleDipilih = isset($_GET['role']) ? $_GET['role'] : '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $roleForm = $_POST['role'];

    // Pastikan role harus ada
    if ($roleForm == "") {
        $error = "Silakan pilih role terlebih dahulu dari halaman utama!";
    } else {

        // Cek user berdasarkan username + role (lebih aman)
        $query = mysqli_query($koneksi, 
            "SELECT * FROM users WHERE username='$username' AND role='$roleForm'"
        );
        $data = mysqli_fetch_assoc($query);

        if ($data) {
            // Verifikasi password otomatis
            if ($password == $data['password']) {

                // Set session utama
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['id_ref'] = $data['id_ref']; // id siswa / id guru / id admin

                // Redirect sesuai role
                if ($data['role'] == "admin") {
                    header("Location: admin/dashboard.php");
                } elseif ($data['role'] == "guru") {
                    header("Location: guru/dashboardguru.php");
                } else {
                    header("Location: siswa/dashboardsiswa.php");
                }
                exit;
            } 
        }

        $error = "Username atau password salah atau role tidak sesuai!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Login Sistem Eskul</h4>
                </div>

                <div class="card-body">

                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php } ?>

                    <form method="POST">

                        <!-- Hidden role dari landing page -->
                        <input type="hidden" name="role" value="<?= $roleDipilih ?>">

                        <?php if ($roleDipilih != "") { ?>
                            <p class="text-center mb-3">
                                Login sebagai <strong><?= strtoupper($roleDipilih) ?></strong>
                            </p>
                        <?php } else { ?>
                            <div class="alert alert-warning">
                                Anda belum memilih role!<br>
                                Silakan kembali ke halaman utama untuk memilih.
                            </div>
                        <?php } ?>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100" name="login">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div> 
</div>

</body>
</html>
