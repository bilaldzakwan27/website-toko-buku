<?php
$koneksi = new mysqli("localhost", "root", "", "pembelianBuku");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home - Grabook Store</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="headerBackground">
            <h1 class="text-center text-danger">
                Admin Panel
            </h1>
        </div>

        <h2 class="text-center mt-3">Selamat Datang <strong><?php echo $_SESSION['admin']['nama_lengkap']; ?></strong></h2>

        <div class="mt-5">
            <h3>Fitur-Fitur Admin</h3>
            <p>Admin panel ini dilengkapi dengan berbagai fitur untuk mengelola toko buku online Anda dengan mudah. Berikut adalah beberapa fitur utama yang tersedia:</p>
            <ul>
                <li><strong>Kelola Produk:</strong> Tambah, edit, dan hapus produk. Anda dapat mengatur informasi produk, gambar, harga, dan stok.</li>
                <li><strong>Kelola Pembeli:</strong> Lihat daftar pembeli, detail pembelian, dan riwayat transaksi.</li>
                <li><strong>Kelola Pelanggan:</strong> Lihat daftar pelanggan, informasi kontak, dan riwayat pembelian mereka.</li>
                <li><strong>Generate Laporan:</strong> Buat laporan pembelian dan statistik penjualan untuk menganalisis kinerja toko Anda.</li>
                <li><strong>Keluar:</strong> Logout dari admin panel untuk keamanan.</li>
            </ul>
        </div>
    </div>
</body>

</html>
