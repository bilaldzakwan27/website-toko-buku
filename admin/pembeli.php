<!DOCTYPE html>
<html>

<head>
	<title>Data Pembeli</title>
	<!-- Bootstrap -->
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

		.btn-info {
			background-color: #3440A8;
			border-color: #3440A8;
			color: #ffffff;
		}

		.btn-success {
			background-color: #FABA26;
			border-color: #FABA26;
			color: #3440A8;
		}

		.btn-info:hover,
		.btn-success:hover {
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
		<h2>Data Pembeli</h2>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Pelanggan</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php $nomor = 1; ?>
				<?php $ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan"); ?>
				<?php while ($pecah = $ambil->fetch_assoc()) { ?>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td><?php echo $pecah["nama_pelanggan"]; ?></td>
						<td><?php echo $pecah["tanggal_pembelian"]; ?></td>
						<td><?php echo $pecah["status_pembelian"]; ?></td>
						<td>Rp. <?php echo number_format($pecah["total_pembelian"]); ?></td>
						<td>
							<a href="index.php?hal=detail&id=<?php echo $pecah['id_pembelian'] ?>"
								class="btn btn-info">Detail</a>
							<?php if ($pecah['status_pembelian'] !== "Tertunda"): ?>
								<a href="index.php?hal=pembayaran&id=<?php echo $pecah['id_pembelian']; ?>"
									class="btn btn-success">Lihat Pembayaran</a>
							<?php endif; ?>
						</td>
					</tr>
					<?php $nomor++; ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</body>

</html>