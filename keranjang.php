<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "pembelianBuku");

//Keranjang Kosong
if (empty($_SESSION['keranjang']) or !isset($_SESSION['keranjang'])) {
    echo "<script> alert('Keranjang Belanja Kosong, Silahkan Berbelanja'); </script>";
    echo "<script> location='index.php'; </script>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #343a40; /* Warna latar belakang */
            color: #fff; /* Warna teks */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
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
                        <li class="nav-item"><a class="btn btn-primary nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten -->
    <section class="konten">
        <div class="container">
            <h1 class="mb-4"><span><em class="fas fa-shopping-cart"></em> Keranjang Belanja</span></h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) : ?>
                        <!-- Menampilkan Produk Perulangan Berdasarkan id_produk-->
                        <?php $ambildata = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'"); ?>
                        <?php $pecah = $ambildata->fetch_assoc(); ?>
                        <tr>
                            <td><?php echo $nomor; ?></td>
                            <td><?php echo $pecah['nama_produk']; ?></td>
                            <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                            <td><?php echo $jumlah ?></td>
                            <td>Rp. <?php echo number_format($pecah['harga_produk'] * $jumlah); ?></td>
                            <td>
                                <a href="hapuskeranjang.php?id=<?php echo $id_produk ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda Yakin ?');">Hapus</a>
                            </td>
                        </tr>
                        <?php $nomor++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-arround">
                <a href="index.php" class="btn btn-success">Lanjut Belanja</a>
                <a href="bayar.php" class="btn btn-primary mx-2">Bayar</a>
                <a href="hapuskeranjang.php?id=<?php echo $id_produk ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin ?');">Hapus Semua</a>
            </div>
        </div>
    </section>

    <!-- jQuery dan Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
