<?php 
	session_start();
?>
<?php
	$koneksi = new mysqli("localhost","root","","pembelianBuku");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    
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
                    <li class="nav-item navbar-text">Welcome, <?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?> </li>
                    <li class="nav-item"><a class="btn btn-danger nav-link ml-2 text-white" href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-primary nav-link text-wthie" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                <?php endif; ?>
            </ul>
            
        </div>
    </div>
</nav>

<section class="konten">
    <div class="container">
        <h2>Detail Pembelian</h2>
        <?php  
            $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'");
            $detail = $ambil->fetch_assoc();
        ?>

        <?php 
        //mendapatkan id yang beli
        $idpelangganyangbeli = $detail['id_pelanggan'];

        //mendapatkan id pelanggan yang login
        $idpelangganyanglogin = $_SESSION['pelanggan']['id_pelanggan'];

        if ($idpelangganyangbeli !== $idpelangganyanglogin) {
            echo "<script> alert('Gagal');</script>";
            echo "<script> location='riwayat .php'; </script>";
        }
        ?>


        <p>
            Kode Pembelian : <strong>H-<?php echo $detail['id_pembelian']; ?>-S</strong><br>
            Tanggal Pembelian : <?php echo $detail['tanggal_pembelian']; ?> <br>
            Harga Pembelian : Rp. <?php echo number_format($detail['total_pembelian'])?>
        </p>
        <div class="row">
            <div class="col-md-4">
                <h3>Pelanggan</h3>
                <strong><?php echo $detail['nama_pelanggan']?></strong>
                <p>Nomor Telepon :  <?php echo $detail['telepon_pelanggan']?><br>Gmail : <?php echo $detail['gmail_pelanggan']; ?>
                </p>    
            </div>
            <div class="col-md-4">
                <h3>Pengirim</h3>
                <strong><?php echo $detail['nama_kurir']; ?></strong>
                <p>Tarif : Rp. <?php echo number_format($detail['tarif']); ?></p>
            </div>
            <div class="col-md-4">
                <h3>Alamat Pengiriman</h3>
                <strong><?php echo $detail['alamat_pengiriman']; ?></strong>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php $nomor = 1; ?>
                <?php $totalbelanja = 0;?>
                <?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk JOIN produk ON pembelian_produk.id_produk=produk.id_produk WHERE pembelian_produk.id_pembelian='$_GET[id]'");?>
                <?php while($pecah = $ambil->fetch_assoc()) { ?>
                    <?php $subharga =  $pecah['harga_produk']*$pecah['jumlah_pembelian']; ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['nama_produk']; ?></td>
                    <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                    <td><?php echo $pecah['jumlah_pembelian']; ?></td>
                    <td>Rp. <?php echo number_format($subharga); ?></td>
                </tr>
                <?php $nomor++; ?>
                <?php $totalbelanja += $subharga; ?>
                <?php } ?>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4">Tarif</th>
                    <td>Rp. <?php echo number_format($detail['tarif']); ?></td>
                </tr>
                <tr>
                    <th colspan="4">TOTAL</th>
                    <th>Rp. <?php echo number_format($totalbelanja + $detail['tarif']); ?></th>
                </tr>
            </tfoot>

        </table>

        <div class="row">
            <div class="col-md-7">
                <div class="alert alert-info">
                    <p>
                        Silahkan melakukan Pembayaran <strong>Rp. <?php echo number_format($detail['total_pembelian'])?></strong>
                        Ke <br>
                        <strong>BANK BCA 00-000-000 AN. UNKNOWN </strong>
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
