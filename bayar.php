<?php
    session_start();
    $koneksi = new mysqli("localhost","root","","pembelianBuku");

    //jika belum masuk/login
    if (!isset($_SESSION['pelanggan'])) {
        echo "<script> alert('Login Terlebih Dahulu, Klik Ok Untuk Melanjutkan Login'); </script>";
        echo "<script> location='login.php' </script>";
    }

    //keranjang kosong
    if (empty($_SESSION['keranjang']) OR !isset($_SESSION['keranjang'])) {
        echo "<script> alert('Keranjang Belanja Kosong, Silahkan Berbelanja'); </script>";
        echo "<script> location='index.php'; </script>";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
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
                    <li class="nav-item navbar-text">Welcome, <?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?></li>
                    <li class="nav-item"><a class="btn btn-danger nav-link ml-2 text-white" href="logout.php" onclick="return confirm('Apakah Anda Yakin ?')">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-primary nav-link text-white" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<!-- konten -->
<section class="konten">
    <div class="container">
        <h1>order detail</h1>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total Belanja</th>
                </tr>
            </thead>

            <tbody>
                <?php $nomor=1; ?>
                <?php $totalbelanja=0; ?>
                <?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
                <!-- Menampilkan Produk Perulangan Berdasarkan id_produk-->
                <?php $ambildata = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'"); ?>
                <?php $pecah = $ambildata->fetch_assoc(); ?>
                <?php $subharga = $pecah['harga_produk']*$jumlah; ?>
                <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['nama_produk']; ?></td>
                    <td>Rp. <?php echo number_format($pecah['harga_produk']); ?></td>
                    <td><?php echo $jumlah ?></td>
                    <td>Rp. <?php echo number_format($subharga); ?></td>
                </tr>
                <?php $nomor++; ?>
                <?php $totalbelanja+=$subharga; ?>
                <?php endforeach ?>
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4">Total Belanja</th>
                    <th>Rp. <?php echo number_format($totalbelanja); ?></th>
                </tr>
            </tfoot>
        </table>

        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" readonly value="<?php echo $_SESSION['pelanggan']['nama_pelanggan']; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Gmail</label>
                        <input type="text" readonly value="<?php echo $_SESSION['pelanggan']['gmail_pelanggan']; ?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" readonly value="<?php echo $_SESSION['pelanggan']['telepon_pelanggan']; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jasa Pengiriman</label>
                        <select class="form-control" name="id_kurir" required="">
                            <option value="">Pilih Jasa Antar</option>
                            <?php 
                                $ambil = $koneksi->query("SELECT * FROM kurir");
                                while($kurir = $ambil->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $kurir['id_kurir']; ?>">
                                <?php echo $kurir['nama_kurir'] ?> - 
                                Rp. <?php echo number_format($kurir['tarif']) ?>    
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Total</label>
                        <input type="text" readonly="" value="Rp. <?php echo number_format($totalbelanja+$kurir); ?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" rows="5" placeholder="Masukkan Alamat Lengkap Anda" name="alamat_pengiriman" required=""></textarea>
            </div>

            <button class="btn btn-outline-danger" name="bayar">Bayar</button>
        </form>

        <?php 
            if (isset($_POST['bayar'])) {
                $id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
                $id_kurir = $_POST['id_kurir'];
                $tanggal_pembelian = date('Y-m-d');
                $alamat_pengiriman = $_POST['alamat_pengiriman'];

                $ambil = $koneksi->query("SELECT * FROM kurir WHERE id_kurir='$id_kurir'");
                $arraykurir = $ambil->fetch_assoc();
                $nama_kurir = $arraykurir['nama_kurir'];
                $kurir = $arraykurir['tarif'];

                $total_pembelian = $totalbelanja+$kurir;

                //1. Menyimpan data ke tabel pembelian
                $koneksi->query("INSERT INTO pembelian (id_pelanggan,id_kurir,tanggal_pembelian,total_pembelian, nama_kurir,tarif,alamat_pengiriman) VALUES ('$id_pelanggan','$id_kurir', '$tanggal_pembelian',
                    '$total_pembelian','$nama_kurir','$kurir','$alamat_pengiriman')");

                //2. Menyimpan data pembelian ke tabel pembelian produk
                //mendapatkan id pembelian barusan terjadi
                $id_pembelian_barusan = $koneksi->insert_id;

                //menyimpan 
                foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
                    $koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,jumlah_pembelian) VALUES ('$id_pembelian_barusan','$id_produk', '$jumlah') ");

                    //mengurangi stok yang dibeli
                    $koneksi->query("UPDATE produk SET stok_produk=stok_produk-$jumlah WHERE id_produk = '$id_produk'");
                }

                //mengkosongkan keranjang belanjaan
                unset($_SESSION['keranjang']);

                //tampilan dialihkan kehalaman nota, nota pembelian barusan
                echo "<script> alert('Pembelian Sukses'); </script>";
                echo "<script> location='nota.php?id=$id_pembelian_barusan'; </script>";

            }

        ?>

    </div>
</section>

<script type="text/javascript" src="admin/assets/js/jquery-3.3.1.min.js"></script>

</body>
</html>
