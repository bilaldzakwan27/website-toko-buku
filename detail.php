<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40; /* Warna latar belakang */
            color: #fff; /* Warna teks */
        }
        .navbar {
            background-color: #212529; /* Warna navbar */
        }
        .navbar-nav .nav-link {
            color: rgba(255,255,255,.5); /* Warna teks navbar */
        }
        .navbar-nav .nav-link:hover {
            color: rgba(255,255,255,.75); /* Warna teks navbar saat dihover */
        }
        .navbar-text {
            color: rgba(255,255,255,.5); /* Warna teks navbar */
        }
        .navbar-text:hover {
            color: rgba(255,255,255,.75); /* Warna teks navbar saat dihover */
        }
        .navbar-brand img {
            max-width: 60px; /* Lebar maksimum logo */
        }
    </style>
</head>
<body>
    <?php 
    session_start();
    $koneksi = new mysqli("localhost", "root", "", "pembelianBuku");

    // Mendapatkan id dari URL
    $id_produk = $_GET['id'];

    // Ambil data dari database
    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
    $detail = $ambil->fetch_assoc();
    ?>

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

    <!-- Konten -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="foto_produk/<?php echo $detail['foto_produk']; ?>" class="img-fluid rounded" alt="<?php echo $detail['nama_produk']; ?>">
                </div>
                <div class="col-md-6">
                    <h2 class="mb-3"><?php echo $detail['nama_produk']; ?></h2>
                    <p class="mb-3">
                        <span class="font-weight-bold">Harga:</span> Rp. <?php echo number_format($detail['harga_produk']); ?>
                    </p>
                    <p class="mb-3">
                        <span class="font-weight-bold">Deskripsi:</span> <?php echo $detail['deskripsi_produk']; ?>
                    </p>
                    <p class="mb-3">
                        <span class="font-weight-bold">Stok Buku:</span> <strong><?php echo $detail['stok_produk']; ?></strong>
                    </p>
                    <form method="post" class="mb-3">
                        <div class="input-group mb-3">
                            <input type="number" min="1" max="<?php echo $detail['stok_produk']; ?>" name="jumlah" class="form-control" placeholder="Masukkan Jumlah Barang" required="">
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger" name="beli" type="submit">Beli</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php
    // Jika ada tombol beli
    if (isset($_POST['beli'])) {
        // Mendapatkan jumlah yang dibeli
        $jumlah = $_POST['jumlah'];
      // Masukkan ke keranjang
        $_SESSION["keranjang"][$id_produk] += $jumlah;

        echo "<script> alert('Produk Masuk Kedalam Keranjang');</script>";
        echo "<script> location='keranjang.php' </script>";
    }
    ?>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
