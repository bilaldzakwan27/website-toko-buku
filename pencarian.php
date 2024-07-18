<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Produk</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    
</head>
<body>

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
                <form action="pencarian.php" method="get" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" name="keyword" placeholder="Pencarian" aria-label="Search">
                <button class="btn btn-danger my-2 my-sm-0" type="submit">Cari</button>
            </form>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['pelanggan'])): ?>
                    <li class="nav-item navbar-text">Welcome, <?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?></li>
                    <li class="nav-item"><a class="btn btn-danger nav-link ml-2 text-white" href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-danger nav-link text-white" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                <?php endif; ?>
            </ul>
            
        </div>
    </div>
</nav>

<?php 
$koneksi = new mysqli("localhost","root","","pembelianBuku");
$keyword = $_GET['keyword'];
$semuadata = array();
$ambildata = $koneksi->query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%'");
while($pecah = $ambildata->fetch_assoc()) {
    $semuadata[]=$pecah;    
}
?>

<div class="container mt-5">
    <h1>Hasil Pencarian: <?php echo $keyword ?></h1>
    <?php if(empty($semuadata)): ?>
        <div class="alert alert-danger"><?php echo $keyword ?> Tidak Ditemukan</div>
    <?php else: ?>
        <div class="row">
            <?php foreach($semuadata as $key => $value): ?>
                <div class="col-md-3">
                    <div class="card mb-3">
                        <img src="foto_produk/<?php echo $value['foto_produk']; ?>" class="card-img-top" alt="Produk">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $value['nama_produk']; ?></h5>
                            <p class="card-text">Stok: <strong><?php echo $value['stok_produk'] ?></strong></p>
                            <p class="card-text">Rp. <?php echo number_format($value['harga_produk']); ?></p>
                            <a href="beli.php?id=<?php echo $value['id_produk']; ?>" class="btn btn-primary btn-sm">Beli</a>
                            <a href="detail.php?id=<?php echo $value['id_produk']; ?>" class="btn btn-warning btn-sm">Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
