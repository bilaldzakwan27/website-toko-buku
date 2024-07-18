<?php 
    session_start();
    $koneksi = new mysqli("localhost","root","","pembelianBuku");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/book-fill.png" alt="bukuKami Logo">bukuKami
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Belanja</a></li>
                    <li class="nav-item"><a class="nav-link" href="rekomendasi.php">Rekomendasi</a></li>
                    <?php if (isset($_SESSION['pelanggan'])): ?>
                        <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                    <?php endif; ?>
                    <?php if(!isset($_SESSION["keranjang"])) : ?>
                        <li class="nav-item"><a class="nav-link" href="keranjang.php">Keranjang<strong>(0)</strong></a></li>
                    <?php else : ?>
                        <li class="nav-item">
                            <?php 
                                $jml = array_sum($_SESSION["keranjang"]);
                            ?>
                            <a class="nav-link" href="keranjang.php">Keranjang<strong>(<?php echo $jml ?>)</strong></a>
                        </li>
                    <?php endif ?>
                    <li class="nav-item"><a class="nav-link" href="bayar.php">Pembayaran</a></li>
                    
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['pelanggan'])): ?>
                        <li class="nav-item navbar-text">Welcome, <?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?></li>
                        <li class="nav-item"><a class="btn btn-danger text-white nav-link ml-2" href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')">Logout</a></li>
                    <?php else: ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white text-center">
                        <h3 class="mb-3">Hello, Welcome Back </h3>
                        <p>Login terlebih dahulu untuk merasakan pengalaman belanja yang menyenangkan.</p>

                    </div>
                    <div class="card-body">
                        <?php if (!isset($_SESSION['pelanggan'])): ?>
                        <?php endif; ?>
                        <form method="post">
                            <div class="form-group">
                                <label for="gmail">Email</label>
                                <input type="email" class="form-control" id="gmail" name="gmail" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <p>Belum punya akun ? <a href="daftar.php">Daftar</a></p>
                            <button type="submit" name="login" class="btn btn-outline-danger ">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST["login"])) {
        $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE gmail_pelanggan='$_POST[gmail]' AND password_pelanggan='$_POST[password]'");
        $akunyangcocok = $ambil->num_rows;
        if ($akunyangcocok==1) {
            $_SESSION['pelanggan'] = $ambil->fetch_assoc();
            echo "<script> alert('Login Berhasil'); </script>";
            echo "<script> location='index.php'; </script>";
        } else {
            echo "<script> alert('Login Gagal, Tekan Ok Untuk Coba Lagi'); </script>";
            echo "<script> location='login.php'; </script>";
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>