<?php 
	session_start();
	$koneksi = new mysqli("localhost","root","","pembelianBuku");

	$id_pembelian = $_GET['id'];

	$ambil = $koneksi->query("SELECT * FROM pembayaran 
		LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian 
		WHERE pembelian.id_pembelian='$id_pembelian'");
	$pecah = $ambil->fetch_assoc();

	//jika belum ada data pembayaran
	if(empty($pecah)){
		echo "<script> alert('Anda Tidak Dapat Mengakses'); </script>";
		echo "<script> location='riwayat.php'; </script>";
		exit();
	}

	//jika data pelanggan yang bayar dan login tidak sama
	if($_SESSION['pelanggan']['id_pelanggan']!==$pecah['id_pelanggan']) {
		echo "<script> alert('Anda Tidak Dapat Mengakses'); </script>";
		echo "<script> location='riwayat.php'; </script>";
		exit();
	}

	// echo "<pre>";
	// 	print_r($pecah);
	// 	print_r($_SESSION);
	// 	echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <style>
        /* Tambahkan CSS kustom di sini */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #3440A8;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #3440A8;
        }
        .navbar, .footer {
            background-color: #3440A8;
            padding: 15px 0;
            border-radius: 10px; /* Rounded corners */
        }
        .navbar-nav > li > a {
            color: white !important;
            font-size: 15px;
        }
        .navbar-nav > li > a:hover {
            color: #FABA26 !important;
        }
        .btn-primary {
            background-color: #3440A8;
            border-color: #3440A8;
            color: white;
        }
        .btn-warning {
            background-color: #FABA26;
            border-color: #FABA26;
            color: #3440A8;
        }
        .btn-success {
            background-color: #34A853;
            border-color: #34A853;
            color: white;
        }
        .btn-danger {
            background-color: #EA4335;
            border-color: #EA4335;
            color: white;
        }
        .thumbnail {
            height: 420px; /* Set a fixed height for all thumbnails */
        }
        .logo-big {
            width: 250px; /* Atur lebar sesuai kebutuhan */
            height: auto; /* Menjaga rasio aspek gambar */
            margin-bottom: 0; /* Mengatur margin bawah jika perlu */
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: #212529;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img class="me-2 logo-big" src="img/grab.png" alt="">
            </a>
        </div>
        <ul class="nav navbar-nav">
            <!-- Jika Sudah Login -->
            <?php if (isset($_SESSION['pelanggan'])): ?>
                <li><a href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')" style="color: white;">Logout</a></li>
                <li><a href="riwayat.php" style="color: white;">Riwayat</a></li>
            <?php endif; ?>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (!isset($_SESSION['pelanggan'])): ?>
                <li>
                    <a href="login.php" class="btn btn-primary custom-button">Login</a>
                </li>
                <li><a href="daftar.php" style="color: white;">Daftar</a></li>
            <?php endif; ?>	
            <li><a href="index.php" style="color:white;">Belanja</a></li>
            <?php if(!isset($_SESSION["keranjang"])) : ?>
                <li><a href="keranjang.php" style="color:white;">Keranjang<strong>(0)</strong></a></li>
            <?php else : ?>
                <hide>
                    <?php $jml=0; ?>
                    <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
                        <!-- Menampilkan Produk Perulangan Berdasarkan id_produk-->
                        <?php $ambildata = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'"); ?>
                        <?php $pecah = $ambildata->fetch_assoc(); ?>
                        <tr>
                            <td><?php $jumlah ?></td>
                        </tr>
                        <?php $jml += $jumlah; ?>
                    <?php endforeach ?>
                </hide>
                <li><a href="rekomendasi.php" style="color: white;">Rekomendasi</a></li>
                <li><a href="keranjang.php" style="color: white;">Keranjang<strong>(<?php echo $jml ?>)</strong></a></li>
            <?php endif ?>
            <li><a href="bayar.php" style="color:white;" >Pembayaran</a></li>
        </ul>
        <form action="pencarian.php" method="get" class="navbar-form navbar-right">
            <input type="text" name="keyword" class="form-control" placeholder="Pencarian">
            <button class="btn btn-primary custom-button">Cari</button>
        </form>
    </div>
</nav>

	<?php 

	$koneksi = new mysqli("localhost","root","","hidupsehat");

	$id_pembelian = $_GET['id'];

	$ambil = $koneksi->query("SELECT * FROM pembayaran 
		LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian 
		WHERE pembelian.id_pembelian='$id_pembelian'");
	$pecah = $ambil->fetch_assoc();

	?>

		<div class="container">
			<h3>Lihat Pembayaran</h3>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<table class="table">
							<tr>
								<th>Nama Penyetor</th>
								<td><?php echo $pecah['nama']; ?></td>
							</tr>
							<tr>
								<th>Bank</th>
								<td><?php echo $pecah['bank']; ?></td>
							</tr>
							<tr>
								<th>Tanggal</th>
								<td><?php echo $pecah['tanggal']; ?></td>
							</tr>
							<tr>
								<th>Jumlah</th>
								<td>Rp. <?php echo number_format($pecah['jumlah']); ?></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="col-md-6">
					<img src="bukti_pembayaran/<?php echo $pecah['bukti']; ?>" class="img-responsive">
				</div>
			</div>
		</div>

</body>
</html>