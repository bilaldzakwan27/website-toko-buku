<?php 
	session_start();
	$koneksi = new mysqli("localhost","root","","pembelianBuku");

	//jika tidak ada session pelanggan maka tidak bisa diakses
	if (!isset($_SESSION['pelanggan']) OR empty($_SESSION['pelanggan'])) {
	echo "<script> alert('Silahkan Login Terlebih Dahulu'); </script>";
	echo "<script> location='login.php' </script>";
	exit();
	}

	//mendapatkan id dari url
	$id_pem = $_GET['id'];
	$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$id_pem'");
	$detpem = $ambil->fetch_assoc();

	//mendapatkan id pelanggan yang beli
	$id_pelanggan_beli = $detpem['id_pelanggan'];
	//mendapatkan id pelanggan yang login
	$id_pelanggan_login = $_SESSION['pelanggan']['id_pelanggan'];

	if ($id_pelanggan_login !== $id_pelanggan_beli) {
		echo "<script> alert('Tidak Dapat Mengakses'); </script>";
		echo "<script> location='riwayat.php' </script>";
		exit();

	}

		// echo "<pre>";
		// print_r($detpem);
		// print_r($_SESSION);
		// echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pembayaran</title>
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

<div class="container">
    <h2>Konfirmasi Pembayaran</h2>
    <p>Kirim Bukti Pembayaran Anda Disini</p>
    <div class="alert alert-info">Total Tagihan Anda <strong>Rp. <?php echo number_format($detpem['total_pembelian']); ?></strong></div>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Penyetor</label>
            <input type="text" name="nama" class="form-control" readonly required="" placeholder="<?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?>">
        </div>
        <div class="form-group">
            <label>Bank</label>
            <input type="text" name="bank" class="form-control" required="">
        </div>
        <div class="form-group">
            <label>Jumlah (Rp.)</label>
            <input type="number" name="jumlah" class="form-control" min="1" required="" placeholder="<?php echo $detpem['total_pembelian']; ?>">
        </div>
        <div class="form-group">
            <label>Foto Bukti</label>
            <input type="file" name="bukti" class="form-control" required="">
            <p class="text-danger">Format Foto Bukti JPG Maksimal 2MB</p>
        </div>
        <button class="btn btn-primary" name="kirim">Kirim</button>
    </form>
</div>

<?php 
if (isset($_POST['kirim'])) {
    
    //upload foto bukti
    $namabukti = $_FILES['bukti']['name'];
    $lokasibukti = $_FILES['bukti']['tmp_name'];
    //agar tidak sama fotonya
    $namafiks = date('YmdHis').$namabukti;
    //lokasi foto
    move_uploaded_file($lokasibukti, "bukti_pembayaran/".$namafiks);

    $tanggal = date('Y-m-d');

    $koneksi->query("INSERT INTO pembayaran(id_pembelian,nama,bank,jumlah,tanggal,bukti)
        VALUES ('$id_pem','$_POST[nama]','$_POST[bank]','$_POST[jumlah]','$tanggal','$namafiks') ");

    //update data pembelian dari pending menjadi sudah kirim pembayaran
    $koneksi->query("UPDATE pembelian SET status_pembelian = 'Proses' WHERE id_pembelian='$id_pem'");
    echo "<script> alert('Terima Kasih Sudah Memberikan Bukti Pembayaran'); </script>";
    echo "<script> location='riwayat.php' </script>";
    exit();
}
?>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
