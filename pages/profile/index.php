<?php
include "../../config.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Profile</title>
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
	<link rel="stylesheet" href="style.css" />
</head>

<body>

	<?php include "../../components/nav.php"; ?>

	<!-- Tambahkan ini di bagian <body> -->
	<div class="container">
		<div class="left">
			<div class="profile-container">
				<img id="profilePreview" src="../../img/default_pp.png" class="profile-img" />
				<label for="uploadInput" class="upload-btn">Pilih Foto</label>
				<input type="file" id="uploadInput" accept="image/*" style="display: none;" />
				<div class="info">Maks. 10MB — JPG, JPEG, PNG</div>
			</div>
		</div>

		<div class="right">
			<!-- Tabs -->
			<div class="tab-container">
				<button class="tab-button active" onclick="showTab('biodata')">Biodata</button>
				<button class="tab-button" onclick="showTab('alamat')">Alamat</button>
			</div>

			<?php
			$user_id = $_SESSION['id_user'];

			$sql = "SELECT * FROM user WHERE id =$user_id";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$user = $result->fetch_assoc();
			} else {
				echo "User not found.";
				exit;
			} ?>
			<!-- Biodata Section -->
			<div id="biodata" class="tab-content">
				<div class="section-title">Ubah Biodata Diri</div>
				<div class="info-row"><span>Username</span>: <?php echo htmlspecialchars($user['username']) ?> <a href="#">Ubah
						Username</a></div>
				<div id="nama-row" class="info-row">
					<span>Nama</span>: <span id="nama-display">Nama Awal</span>
					<a href="#" onclick="openNamaModal(event)">Ubah nama</a>
				</div>
				<div id="namaModal" class="modal">
					<div class="modal-content">
						<span class="close" onclick="closeNamaModal()">&times;</span>
						<h3>Ubah Nama</h3>
						<input type="text" id="nama-input-modal" />
						<div style="margin-top: 10px;">
							<button onclick="simpanNama()">Simpan</button>
							<button onclick="closeNamaModal()">Batal</button>
						</div>
					</div>
				</div>

				<div class="info-row"><span>Tanggal Lahir</span>: <a href="#">Tambah Tanggal Lahir</a></div>
				<div class="info-row"><span>Jenis Kelamin</span>: <a href="#">Tambah Jenis Kelamin</a></div>
				<div class="section-title">Ubah Kontak</div>
				<div class="info-row"><span>Email</span>: <?php echo htmlspecialchars($user['email']) ?> <a href="#">Tambah
						Email</a></div>
				<div class="info-row"><span>Nomor HP</span>: <a href="#">Ubah</a></div>
			</div>

			<!-- Alamat Section -->
			<div id="alamat" class="tab-content" style="display: none;">
				<div class="section">
					<h3>Daftar Alamat</h3>
					<div class="row">
						<p><strong>Alamat Utama</strong>: Jl. Melati No. 45, Jakarta</p>
						<button class="edit-btn">Ubah</button>
					</div>
					<div class="row">
						<p><strong>Alamat Tambahan</strong>: Tambah Alamat Baru</p>
						<button class="edit-btn">Tambah</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include "../../components/footer.php" ?>
	
	<script src="script.js"></script>
</body>

<!-- JavaScript di akhir halaman -->

</html>