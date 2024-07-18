<?php
// Account dimasukkan ke dalam session
session_start();

$koneksi = new mysqli("localhost", "root", "", "pembelianBuku");

// Harus login
if (!isset($_SESSION['admin'])) {
    echo "<script>alert('Anda Belum Login, Silahkan Tekan Ok Untuk Login');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        
            <a class="navbar-brand" href="#">
                <img src="../img/grab.png" alt="Logo" style="width: 200px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?hal=logout">Logout</a>
                    </li>
                </ul>
            </div>
    </nav>


    <div class="container-fluid mt-3">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="fa fa-home"></i> Admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?hal=produk">
                                <i class="fa fa-book"></i> Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?hal=pembeli">
                                <i class="fa fa-shopping-cart"></i> Pembeli
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?hal=pelanggan">
                                <i class="fa fa-user"></i> Pelanggan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <!-- Content goes here -->
                <?php
                // Include content based on the 'hal' parameter
                if (isset($_GET['hal'])) {
                    if ($_GET['hal'] == "produk") {
                        include 'produk.php';
                    } elseif ($_GET['hal'] == "pembeli") {
                        include 'pembeli.php';
                    } elseif ($_GET['hal'] == "pelanggan") {
                        include 'pelanggan.php';
                    } elseif ($_GET['hal'] == "hapuspelanggan") {
                        include 'hapuspelanggan.php';
                    } elseif ($_GET['hal'] == "ubahpelanggan") {
                        include 'ubahpelanggan.php';
                    } elseif ($_GET['hal'] == "detail") {
                        include 'detail.php';
                    } elseif ($_GET['hal'] == "tambahproduk") {
                        include 'tambahproduk.php';
                    } elseif ($_GET['hal'] == "hapusproduk") {
                        include 'hapusproduk.php';
                    } elseif ($_GET['hal'] == "ubahproduk") {
                        include 'ubahproduk.php';
                    } elseif ($_GET['hal'] == "logout") {
                        include 'logout.php';
                    } elseif ($_GET['hal'] == "pembayaran") {
                        include 'pembayaran.php';
                    } elseif ($_GET['hal'] == "laporan_pembelian") {
                        include 'laporan_pembelian.php';
                    }
                } else {
                    include 'home.php';
                }
                ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
