<!DOCTYPE html>
<html>

<head>
    <title>Data Buku</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="m-0">Data Buku</h2>
            </div>
            <div class="card-body">
                <a href="index.php?hal=tambahproduk" class="btn btn-primary mb-3">Tambah Data</a>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Harga (Rp)</th>
                                <th>Berat (Gr)</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1; ?>
                            <?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
                            <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $pecah['nama_produk']; ?></td>
                                    <td><?php echo $pecah['harga_produk']; ?></td>
                                    <td><?php echo $pecah['berat_produk']; ?></td>
                                    <td><img src="../foto_produk/<?php echo $pecah['foto_produk']; ?>" class="img-fluid" width="100"></td>
                                    <td>
                                        <a href="index.php?hal=ubahproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-warning">Ubah</a>
                                        <a href="index.php?hal=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <?php $nomor++; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
