<?php session_start(); ?>
<?php $koneksi = new mysqli("localhost","root","","pembelianBuku"); ?>
<?php 
//jika tidak ada session pelanggan maka tidak bisa diakses
if (!isset($_SESSION['pelanggan'])) {
	echo "<script> alert('Silahkan Login Terlebih Dahulu'); </script>";
	echo "<script> location='login.php' </script>";
	exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
        
</head>
<body class="bg-dark text-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">
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

<!-- section -->
<section class="riwayat">
    <div class="container">
        <h3>Riwayat Pembelian dari user : <?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?></h3>
        <span><em class="fas fa-folder-open"></em>&nbsp; Riwayat Belanja</span>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Pembelian</th>
                    <th>Status Pembelian</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1; ?>
                <?php 
                //mendapatkan id yang login
                $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
                //ambil dan pecahkan
                $ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan = '$id_pelanggan'");
                while($pecah = $ambil->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['tanggal_pembelian']; ?></td>
                    <td><?php echo $pecah['status_pembelian']; ?>
                        <br>
                        <?php if(!empty($pecah['resi_pengiriman'])): ?>
                        No.Resi <?php echo $pecah['resi_pengiriman']; ?>
                        <?php endif  ?>
                    </td>
                    <td>Rp. <?php echo number_format($pecah['total_pembelian']); ?></td>
                    <td>
                        <a href="nota.php?id=<?php echo $pecah['id_pembelian']?>" class="btn btn-warning">Nota</a>
                        <?php if($pecah['status_pembelian']=='Tertunda'): ?>
                            <a href="pembayaran.php?id=<?php echo $pecah['id_pembelian']?>" class="btn btn-success">Pembayaran</a>
                        <?php else: ?>
                            <!-- <a href="lihat_pembayaran.php?id=<?php echo $pecah['id_pembelian']?>" class="btn btn-warning">Lihat</a> -->
                        <?php endif ?>
                    </td>
                </tr>
                <?php $nomor++ ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
