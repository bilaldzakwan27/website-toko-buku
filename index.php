<?php 
    session_start();
    $koneksi = new mysqli("localhost","root","","pembelianBuku");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
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
            background-color: #495057;
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
<nav class="navbar navbar-expand-lg navbar-light bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="img/logo.png" alt="bukuKami Logo"> tokobukuradit
        </a>
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
            <form action="pencarian.php" method="get" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Pencarian" aria-label="Search">
                <button class="btn btn-primary my-2 my-sm-0" type="submit">Cari</button>
            </form>
        </div>
    </div>
</nav>

<!-- Jumbotron -->
<div class="jumbotron text-center">
    <h1 class="display-4">Hello, <?php echo isset($_SESSION['pelanggan']) ? $_SESSION['pelanggan']['nama_pelanggan'] : 'Pengunjung'; ?>!</h1>
    <p class="lead">Selamat datang di toko Buku Radit.</p>
</div>

<!-- Content -->
<section class="konten">
    <div class="container">
        <h2 class="text-center">Buku Terbaru</h2>
        <div class="meta-post text-center">
            <span><em class="glyphicon glyphicon-th-list"></em>Buku-buku dari tere Liye</span>&nbsp;&nbsp;
        </div>
        <div class="row">
            <?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
            <?php while ($perproduk = $ambil->fetch_assoc()) { ?>
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm" onclick="window.location='detail.php?id=<?php echo $perproduk['id_produk']; ?>'">
                        <div class="thumbnail">
                            <img class="card-img-top" src="foto_produk/<?php echo $perproduk['foto_produk']; ?>" alt="Product Image">
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $perproduk['nama_produk']; ?></h5>
                            <p class="card-text">Stok: 
                                <?php echo ($perproduk['stok_produk'] >= 1) ? $perproduk['stok_produk'] : "<strong>Habis</strong>"; ?>
                            </p>
                            <p class="card-text">Rp. <?php echo number_format($perproduk['harga_produk']); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p>&copy; Copyright tokobukuradit Store 2024</p>
    </div>
</footer>

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
