<?php
include "../../config.php";
session_start();

$user_id = $_SESSION['id_user'];

// Query untuk mengambil semua pesanan dengan berbagai status
$sql = "SELECT 
    p.id,
    p.tgl_pesan,
    p.status,
    GROUP_CONCAT(f.id SEPARATOR ', ') produk,
    SUM(f.harga * pi.quantity) total
FROM pesanan p
JOIN pesanan_item pi ON p.id = pi.pesanan_id
JOIN furniture f ON pi.furniture_id = f.id
WHERE p.user_id = $user_id
GROUP BY p.id
ORDER BY p.tgl_pesan DESC";

$result = mysqli_query($conn, $sql);

if ($result) {
	$pesanan = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$pesananByStatus = [
	'Dikemas' => [],
	'Dikirim' => [],
	'Sampai' => [],
	'Selesai' => []
];

foreach ($pesanan as $item) {
	$status = $item['status'];

	$produkIdsString = $item['produk'];
	$item['produk'] = [];
	foreach (explode(', ', $produkIdsString) as $produkId) {
		$sqlProduk = "SELECT f.nama, f.deskripsi, f.harga, pi.quantity, f.harga, fg.gambar FROM furniture f JOIN pesanan_item pi ON f.id = pi.furniture_id JOIN furniture_gambar fg ON f.id = fg.furniture_id WHERE f.id = $produkId AND f.gambar_utama = fg.id ";
		$resultProduk = mysqli_query($conn, $sqlProduk);
		if ($resultProduk) {
			$produk = mysqli_fetch_assoc($resultProduk);
			$item['produk'][] = $produk;
		}
	}

	if (array_key_exists($status, $pesananByStatus)) {
		$pesananByStatus[$status][$item['id']] = $item;
	}
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
	<script>
		tailwind.config = {
			darkMode: "class",
			theme: {
				fontFamily: {
					'sans': ["Poppins", 'sans-serif'],
				},
			}
		}
	</script>
	<title>Document</title>
	<style>
		/* CSS tetap sama seperti sebelumnya */
		body {
			font-family: 'Poppins', sans-serif;
			background: #fff;
		}

		.tabs {
			display: flex;
			gap: 10px;
			margin-bottom: 20px;
		}

		.tab-btn {
			padding: 8px 16px;
			border: none;
			border-radius: 20px;
			background-color: #eee;
			cursor: pointer;
		}

		.tab-btn.active {
			background-color: #E3DCD6;
			color: #B5733A;
			font-weight: bold;
		}

		.tab-content {
			display: none;
		}

		.tab-content.active {
			display: block;
		}

		.transaction-card {
			border: 1px solid #eee;
			border-radius: 12px;
			padding: 16px;
			margin-bottom: 20px;
			background-color: #fff;
		}

		.transaction-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 10px;
			font-size: 14px;
			flex-wrap: wrap;
		}

		.header-left span {
			margin-right: 10px;
		}

		.badge.success {
			background-color: #E3DCD6;
			color: #B5733A;
			padding: 2px 8px;
			border-radius: 6px;
			font-weight: bold;
			font-size: 12px;
		}

		.store-name {
			font-weight: 600;
			margin-bottom: 10px;
			font-size: 15px;
			color: #B5733A;
		}

		.product-list {
			display: flex;
			flex-direction: column;
			gap: 12px;
		}

		.product-item {
			display: flex;
			align-items: flex-start;
			gap: 12px;
		}

		.product-img {
			width: 60px;
			height: 60px;
			object-fit: cover;
			border-radius: 6px;
		}

		.product-details {
			flex: 1;
		}

		.product-name {
			font-size: 14px;
		}

		.product-qty {
			color: #666;
			font-size: 13px;
		}

		.transaction-footer {
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			margin-top: 16px;
			flex-wrap: wrap;
		}

		.total {
			font-size: 14px;
		}

		.total-price {
			font-weight: bold;
			font-size: 16px;
		}

		.buttons {
			display: flex;
			gap: 8px;
			margin-top: 8px;
			flex-wrap: wrap;
		}

		.btn-link {
			color: #B5733A;
			text-decoration: none;
			font-weight: 600;
		}

		.btn-outline {
			border: 1px solid #B5733A;
			color: #B5733A;
			padding: 6px 12px;
			background: white;
			border-radius: 6px;
			font-weight: 600;
			cursor: pointer;
		}

		.btn-primary {
			background-color: #B5733A;
			color: white;
			padding: 6px 14px;
			border: none;
			border-radius: 6px;
			font-weight: 600;
			cursor: pointer;
		}

		.btn-more {
			padding: 6px 10px;
			border: 1px solid #ccc;
			background-color: #f9f9f9;
			border-radius: 6px;
			cursor: pointer;
		}
	</style>
</head>

<body class="bg-gray-50">

	<?php include "../../components/nav.php"; ?>

	<main class="mt-32 mb-24 mx-20">
		<h1 class="text-2xl font-bold mb-6">Daftar Pesanan</h1>
		<div class="tabs">
			<button class="tab-btn active" onclick="showTab('dikemas')">Dikemas</button>
			<button class="tab-btn" onclick="showTab('dikirim')">Dikirim</button>
			<button class="tab-btn" onclick="showTab('tiba')">Tiba di Tujuan</button>
			<button class="tab-btn" onclick="showTab('selesai')">Selesai</button>
		</div>

		<!-- Tab Dikemas -->
		<div id="dikemas" class="tab-content active">
			<?php if (!empty($pesananByStatus['Dikemas'])): ?>
				<?php foreach ($pesananByStatus['Dikemas'] as $id => $pesanan): ?>
					<div class="transaction-card">
						<div class="transaction-header">
							<div class="header-left">
								<span><?= date('d M Y', strtotime($pesanan['tgl_pesan'])) ?></span>
								<span class="badge success"><?= $pesanan['status'] ?></span>
							</div>
							<div class="header-right">
								<span>ID Pesanan: <?= $id ?></span>
							</div>
						</div>
						<div class="product-list">
							<?php foreach ($pesanan['produk'] as $produk): ?>
								<div class="product-item">
									<img src="../../img/upload/<?= $produk['gambar'] ?>" alt="Produk" class="product-img">
									<div class="product-details">
										<div class="product-name">Produk: <?= htmlspecialchars($produk['nama']) ?></div>
										<div class="product-qty"><?= $produk['harga'] ?> x <?= $produk['quantity'] ?></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="transaction-footer">
							<div class="total">Total: <span class="total-price">Rp.
									<?= number_format($pesanan['total'], 0, ',', '.') ?></span></div>
							<div class="buttons"></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p>Tidak ada pesanan yang dikemas</p>
			<?php endif; ?>
		</div>

		<!-- Tab Dikirim -->
		<div id="dikirim" class="tab-content">
			<?php if (!empty($pesananByStatus['Dikirim'])): ?>
				<?php foreach ($pesananByStatus['Dikirim'] as $id => $pesanan): ?>
					<div class="transaction-card">
						<div class="transaction-header">
							<div class="header-left">
								<span><?= date('d M Y', strtotime($pesanan['tgl_pesan'])) ?></span>
								<span class="badge success"><?= $pesanan['status'] ?></span>
							</div>
							<div class="header-right">
								<span>ID Pesanan: <?= $id ?></span>
							</div>
						</div>
						<div class="product-list">
							<?php foreach ($pesanan['produk'] as $produk): ?>
								<div class="product-item">
									<img src="../../img/upload/<?= $produk['gambar'] ?>" alt="Produk" class="product-img">
									<div class="product-details">
										<div class="product-name">Produk: <?= htmlspecialchars($produk['nama']) ?></div>
										<div class="product-qty"><?= $produk['harga'] ?> x <?= $produk['quantity'] ?></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="transaction-footer">
							<div class="total">Total: <span class="total-price">Rp.
									<?= number_format($pesanan['total'], 0, ',', '.') ?></span></div>
							<div class="buttons"></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p>Tidak ada pesanan yang dikemas</p>
			<?php endif; ?>
		</div>

		<!-- Tab Tiba di Tujuan -->
		<div id="tiba" class="tab-content">
			<?php if (!empty($pesananByStatus['Sampai'])): ?>
				<?php foreach ($pesananByStatus['Sampai'] as $id => $pesanan): ?>
					<div class="transaction-card">
						<div class="transaction-header">
							<div class="header-left">
								<span><?= date('d M Y', strtotime($pesanan['tgl_pesan'])) ?></span>
								<span class="badge success"><?= $pesanan['status'] ?></span>
							</div>
							<div class="header-right">
								<span>ID Pesanan: <?= $id ?></span>
							</div>
						</div>
						<div class="product-list">
							<?php foreach ($pesanan['produk'] as $produk): ?>
								<div class="product-item">
									<img src="../../img/upload/<?= $produk['gambar'] ?>" alt="Produk" class="product-img">
									<div class="product-details">
										<div class="product-name">Produk: <?= htmlspecialchars($produk['nama']) ?></div>
										<div class="product-qty"><?= $produk['harga'] ?> x <?= $produk['quantity'] ?></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="transaction-footer">
							<div class="total">Total: <span class="total-price">Rp.
									<?= number_format($pesanan['total'], 0, ',', '.') ?></span></div>
							<div class="buttons"></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p>Tidak ada pesanan yang sampai</p>
			<?php endif; ?>
		</div>

		<!-- Tab Selesai -->
		<div id="selesai" class="tab-content">
			<?php if (!empty($pesananByStatus['selesai'])): ?>
				<?php foreach ($pesananByStatus['selesai'] as $id => $pesanan): ?>
					<div class="transaction-card">
						<div class="transaction-header">
							<div class="header-left">
								<span><?= date('d M Y', strtotime($pesanan['tgl_pesan'])) ?></span>
								<span class="badge success"><?= $pesanan['status'] ?></span>
							</div>
							<div class="header-right">
								<span>ID Pesanan: <?= $id ?></span>
							</div>
						</div>
						<div class="product-list">
							<?php foreach ($pesanan['produk'] as $produk): ?>
								<div class="product-item">
									<img src="../../img/upload/<?= $produk['gambar'] ?>" alt="Produk" class="product-img">
									<div class="product-details">
										<div class="product-name">Produk: <?= htmlspecialchars($produk['nama']) ?></div>
										<div class="product-qty"><?= $produk['harga'] ?> x <?= $produk['quantity'] ?></div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="transaction-footer">
							<div class="total">Total: <span class="total-price">Rp.
									<?= number_format($pesanan['total'], 0, ',', '.') ?></span></div>
							<div class="buttons"></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p>Tidak ada pesanan yang selesai</p>
			<?php endif; ?>
		</div>
	</main>

	<?php include "../../components/footer.php"; ?>

	<script>
		function showTab(id) {
			document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));
			document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
			document.getElementById(id).classList.add('active');
			event.target.classList.add('active');
		}
	</script>
</body>

</html>