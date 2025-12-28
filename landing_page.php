<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web Ekstrakurikuler</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f3e8d3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Card Role */
        .role-card {
            border: none;
            border-radius: 16px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 5px;
            width: 100%;
            background-color: #0d6efd;
        }

        .role-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .role-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        footer {
            margin-top: 80px;
            padding: 20px 0;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container text-center mt-5">

    <!-- Judul -->
    <h2 class="fw-bold mb-3">Selamat Datang di Web Ekstrakurikuler</h2>
    <p class="text-muted mb-5 mx-auto" style="max-width: 550px;">
        Yuk, berkembang bareng lewat kegiatan ekstrakurikuler!  
        Pilih peran kamu untuk masuk ke dalam sistem dan jelajahi berbagai aktivitas
        yang dapat meningkatkan bakat dan minatmu.
    </p>

    <!-- Card Role -->
    <div class="row justify-content-center g-4">

        <!-- Siswa -->
        <div class="col-md-3 col-sm-6">
            <a href="login.php?role=siswa" class="text-decoration-none text-dark">
                <div class="card role-card p-4 h-100">
                    <img src="img/gambarsiswa1.png" alt="Siswa" class="mx-auto role-img">
                    <h5 class="mt-3 fw-semibold">Siswa</h5>
                    <p class="text-muted small mt-2">
                        Mengikuti dan mendaftar kegiatan ekstrakurikuler
                    </p>
                </div>
            </a>
        </div>

        <!-- Guru -->
        <div class="col-md-3 col-sm-6">
            <a href="login.php?role=guru" class="text-decoration-none text-dark">
                <div class="card role-card p-4 h-100">
                    <img src="img/guru1.png" alt="Guru" class="mx-auto role-img">
                    <h5 class="mt-3 fw-semibold">Guru</h5>
                    <p class="text-muted small mt-2">
                        Membina dan mengelola kegiatan ekstrakurikuler
                    </p>
                </div>
            </a>
        </div>

        <!-- Admin -->
        <div class="col-md-3 col-sm-6">
            <a href="login.php?role=admin" class="text-decoration-none text-dark">
                <div class="card role-card p-4 h-100">
                    <img src="img/admin1.png" alt="Admin" class="mx-auto role-img">
                    <h5 class="mt-3 fw-semibold">Admin</h5>
                    <p class="text-muted small mt-2">
                        Mengatur sistem dan manajemen data pengguna
                    </p>
                </div>
            </a>
        </div>

    </div>

    <!-- CTA -->
    <p class="text-secondary mt-5">
        Klik salah satu role di atas untuk melanjutkan ke halaman login
    </p>

</div>

<!-- Footer -->
<footer class="text-center">
    © 2025 Web Ekstrakurikuler | RPL SVENS XI PPLG 2
</footer>

</body>
</html>
