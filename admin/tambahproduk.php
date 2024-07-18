<h2>Tambah Produk</h2>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required>
    </div>
    <div class="form-group">
        <label>Harga (Rp)</label>
        <input type="number" class="form-control" name="harga" required>
    </div>
    <div class="form-group">
        <label>Berat (Gr)</label>
        <input type="number" class="form-control" name="berat" required>
    </div>
    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto" required>
    </div>
    <div class="form-group">
        <label>Stok Produk</label>
        <input type="number" class="form-control" name="stok" required>
    </div>    
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea class="form-control" name="deskripsi" rows="10" required></textarea>
    </div>
    <div class="form-group">
        <label>Cover Buku Tambahan</label>
        <input type="file" class="form-control" name="resep" required>
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php  
if (isset($_POST['save'])) {
    $nama = $_FILES['foto']['name'];
    $lokasi = $_FILES['foto']['tmp_name'];
    $namaresep = $_FILES['resep']['name'];
    $lokasiresep = $_FILES['resep']['tmp_name'];

    // Ensure directories exist
    if (!is_dir('../foto_produk')) {
        mkdir('../foto_produk', 0777, true);
    }
    if (!is_dir('../resep_produk')) {
        mkdir('../resep_produk', 0777, true);
    }

    // Move uploaded files
    if (move_uploaded_file($lokasi, "../foto_produk/".$nama) && move_uploaded_file($lokasiresep, "../resep_produk/".$namaresep)) {
        // Insert data into the database
        $nama_produk = $koneksi->real_escape_string($_POST['nama']);
        $harga_produk = $koneksi->real_escape_string($_POST['harga']);
        $berat_produk = $koneksi->real_escape_string($_POST['berat']);
        $deskripsi_produk = $koneksi->real_escape_string($_POST['deskripsi']);
        $stok_produk = $koneksi->real_escape_string($_POST['stok']);

        $query = "INSERT INTO produk (nama_produk, harga_produk, berat_produk, foto_produk, deskripsi_produk, resep_produk, stok_produk) 
                  VALUES ('$nama_produk', '$harga_produk', '$berat_produk', '$nama', '$deskripsi_produk', '$namaresep', '$stok_produk')";

        if ($koneksi->query($query)) {
            echo "<div class='alert alert-info'>Data Tersimpan</div>";
            echo "<meta http-equiv='refresh' content='1;url=index.php?hal=produk'>";
        } else {
            echo "<div class='alert alert-danger'>Data Gagal Tersimpan: " . $koneksi->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Upload Gagal</div>";
    }
}
?>
