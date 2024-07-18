<!DOCTYPE html>
<html>

<head>
	<title>Data Pelanggan</title>
	<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap"
		rel="stylesheet">
	<style>
		body {
			font-family: 'Poppins', sans-serif;
			background-color: #ffffff;
			color: #3440A8;
		}

		h2 {
			color: #3440A8;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th,
		td {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		th {
			background-color: #3440A8;
			color: #ffffff;
		}

		td {
			background-color: #ffffff;
		}

		.btn-warning {
			background-color: #3440A8;
			border-color: #3440A8;
			color: #ffffff;
		}

		.btn-danger {
			background-color: #FABA26;
			border-color: #FABA26;
			color: #3440A8;
		}

		.btn-warning:hover,
		.btn-danger:hover {
			background-color: #ffffff;
			border-color: #3440A8;
			color: #3440A8;
		}

		#container {
			border-radius: 10px;
			background-color: #f2f2f2;
			padding: 20px;
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<div id="container">
		<h2>Data Pelanggan</h2>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Gmail</th>
					<th>Telepon</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $nomor = 1; ?>
				<?php $ambil = $koneksi->query("SELECT * FROM pelanggan"); ?>
				<?php while ($pecah = $ambil->fetch_assoc()) { ?>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td><?php echo $pecah["nama_pelanggan"]; ?></td>
						<td><?php echo $pecah["gmail_pelanggan"]; ?></td>
						<td><?php echo $pecah["telepon_pelanggan"]; ?></td>
						<td>
							<a href="index.php?hal=ubahpelanggan&id=<?php echo $pecah['id_pelanggan']; ?>"
								class="btn btn-warning">Ubah</a>
							<a href="index.php?hal=hapuspelanggan&id=<?php echo $pecah['id_pelanggan']; ?>"
								class="btn btn-danger">Hapus</a>
						</td>
					</tr>
					<?php $nomor++; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>

</html>