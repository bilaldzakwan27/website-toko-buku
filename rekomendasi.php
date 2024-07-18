<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #f8f9fa;
        }

        .navbar-light .navbar-brand {
            color: #f8f9fa;
        }
       
        .navbar-brand img {
            height: 40px;
        }

        .navbar-light .navbar-nav .nav-link:hover {
            color: #adb5bd;
        }

        .card {
            transition: transform 0.5s ease;
            background-color: #495057;
            border: none;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img-top {
            transition: transform 0.5s ease;
        }
        .footer {
            background-color: #212529;
            padding: 20px 0;
            color: white;
        }
        .footer p {
            margin: 0;
        }
        .meta-post {
            margin-bottom: 20px;
        }
        .meta-post span {
            display: inline-block;
            margin-right: 10px;
            color: #6c757d;
        }

        .jumbotron {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .form-control {
            background-color: #495057;
            border: none;
            color: #f8f9fa;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="img/logo.png" alt="tokobukuradit Logo"> tokobukuradit
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Belanja</a></li>
                    <li class="nav-item"><a class="nav-link" href="rekomendasi.php">Rekomendasi</a></li>
                    <?php if (isset($_SESSION['pelanggan'])) : ?>
                        <li class="nav-item"><a class="nav-link" href="riwayat.php">Riwayat</a></li>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION["keranjang"])) : ?>
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
                    <?php if (isset($_SESSION['pelanggan'])) : ?>
                        <li class="nav-item navbar-text">Welcome, <?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?></li>
                        <li class="nav-item"><a class="btn btn-danger nav-link ml-2 text-white" href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')">Logout</a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="btn btn-primary nav-link text-white" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Jumbotron -->
    <div class="jumbotron text-center">
        <h1 class="display-4">Buku Rekomendasi dari Toko Radit</h1>
    </div>

    <!-- New Book Section -->
    <section class="container mt-4">
        <h2 class="text-center mb-4">Buku Rekomendasi</h2>
        <div class="row">
            <!-- Example Book -->
            <div class="col-md-3">
                <div class="card mb-4 shadow-sm">
                    <a href="index.php" class="thumbnail">
                        <div class="card-body text-center">
                            <h5 class="card-title">belum ada buku Rekomendasi</h5>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Repeat for other books -->
            <!-- <div class="col-md-3">
            <div class="card mb-4 shadow-sm">
                <a href="index.php" class="thumbnail">
                    <img src="img/tb2.jpg" class="card-img-top" alt="Book Image">
                    <div class="card-body text-center">
                        <h5 class="card-title">Auguste Dupin : Detektif Prancis</h5>
                    </div>
                </a>
            </div>
        </div> -->
        </div>
    </section>
    <!-- End of New Book Section -->

    

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $('.carousel').carousel({
            interval: 2000
        });
    </script>
</body>

</html>
