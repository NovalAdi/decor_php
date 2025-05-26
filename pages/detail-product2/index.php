<?php
include "../../config.php";
session_start();

$id = $_GET['id'];
$sql = "SELECT f.nama, f.deskripsi, f.harga, IFNULL(ROUND(AVG(r.rate), 1), 0.0) AS rating, GROUP_CONCAT(DISTINCT t.nama SEPARATOR ', ') AS tag, GROUP_CONCAT(DISTINCT g.gambar SEPARATOR ', ') as gambar FROM furniture f join furniture_gambar g on f.id = g.furniture_id LEFT JOIN review_furniture rf ON f.id = rf.furniture_id LEFT JOIN review r ON rf.review_id = r.id LEFT JOIN furniture_tag ft ON f.id = ft.furniture_id LEFT JOIN tag t ON ft.tag_id = t.id WHERE f.id = $id GROUP BY f.id, f.nama, f.harga";

$result = mysqli_query($conn, $sql);

if ($result) {
	$_SESSION['product'] = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
}

if (isset($_POST['btnAddToCart'])) {
	$sqlC = "INSERT INTO cart (id, id_produk, id_user, id_pesanan, quantity) VALUES (NULL, " . $_SESSION['product']['id'] . ", " . $_SESSION['id_user'] . ", NULL, " . $_POST['quantity'] . ")";
	$resultC = mysqli_query($conn, $sqlC);


	if ($resultC) {
		header("Location: ../cart");
	}
}

$_SESSION['product']['gambar'] = array_map('trim', explode(',', $_SESSION['product']['gambar']));
?>

<!DOCTYPE html>
<html lang="en">

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
</head>

<body class="font-sans">

	<?php include "../../components/nav.php"; ?>

	<!-- detail Produk -->
	<form method="post">
		<section class="detail mt-24">
			<div class="box flexx">
				<div class="left">
					<div class="main-img">
						<img src="../../img/upload/<?= $_SESSION['product']['gambar'][0] ?>" id="mainImage" alt="" class="slide" style="width: 450px; height: 300px; object-fit: cover;">
					</div>
					<div class="thumbnail-container" style="display: flex; gap: 15px; margin-top: 10px; cursor: pointer;">
						<?php foreach ($_SESSION['product']['gambar'] as $key => $value) { ?>
							<img src="../../img/upload/<?= $value ?>" class="thumbnail" alt="" class="slide" style="width: 80px; height: 80px; object-fit: cover; ">
						<?php } ?>
					</div>
				</div>
				<div class="right">
					<div class="product">
						<h3 class="title"><?= $_SESSION['product']['nama'] ?></h3>
						<div class="sells">
							<i class="fa-solid fa-star star"></i>
							<p id="rating"><?= $_SESSION['product']['rating'] ?></p>
							<p>|</p>
							<p>32 reviews</p>
						</div>
					</div>
					<div class="deskripsi">
						<div class="prc1">
							<h1 id="price">Rp.<?= number_format($_SESSION['product']['harga'], 0, ',', '.') ?></h1>
						</div>
						<div class="detail1">
							<p id="detail"><?= $_SESSION['product']['deskripsi'] ?></p>
						</div>
					</div>
				</div>
				<div class="middle">
					<div class="checkout-sect">
						<h1>Atur Jumlah</h1>
						<div class="stock">
							<h5 class="mt-2">Quantity</h5>
						</div>
						<div class="flex gap-2 mb-5 mt-2">
							<button type="button" class="w-[30px] p-1 border rounded-full border-1 text-center hover:bg-gray-200"
								onclick="minusCounter()">-</button>
							<input class="py-1 px-2 border rounded-full border-1 w-[50px] text-center bg-white" id="counter"
								type="text" readonly value="1" min="1" name="quantity">
							<button type="button" class="w-[30px] p-1 border rounded-full border-1 text-center hover:bg-gray-200"
								onclick="addCounter()">+</button>
						</div>
						<div class="total">
							<p id="total">Total</p>
							<input type="text" class="text-end" id="harga" disabled
								value="Rp.<?= number_format($_SESSION['product']['harga'], 0, ',', '.') ?>">
						</div>
						<input class="btn" name="btnAddToCart" type="submit" value="Add To Cart">
					</div>
					<div class="option2">
						<div class="icon">
							<i class="fa-regular fa-comment"></i>
							<p>Chat</p>
						</div>
						<p>|</p>
						<div class="icon">
							<i class="fa-regular fa-heart"></i>
							<p>Wishlist</p>
						</div>
						<p>|</p>
						<div class="icon">
							<i class="fa-solid fa-arrow-up-from-bracket"></i>
							<p>Share</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</form>


	<?php include "../../components/footer.php" ?>

	<script>
		let counter = document.getElementById('counter');
		let harga = document.getElementById('harga');
		let number = parseInt(harga.value.replace(/[^0-9]/g, ''));
		let hargaSatuan = number / counter.value;

		function formatRupiah(angka) {
			return "Rp." + angka.toLocaleString("id-ID");
		}

		function updateHarga() {
			let total = hargaSatuan * parseInt(counter.value);
			harga.value = formatRupiah(total);
		}

		function addCounter() {
			counter.value = parseInt(counter.value) + 1;
			updateHarga();
		}

		function minusCounter() {
			if (parseInt(counter.value) > 1) {
				counter.value = parseInt(counter.value) - 1;
				updateHarga();
			}
		}

		const mainImage = document.getElementById("mainImage");
		const thumbnails = document.querySelectorAll(".thumbnail");

		thumbnails.forEach(thumbnail => {
			thumbnail.addEventListener('click', function() {
				mainImage.src = thumbnail.src;
			});
		});
	</script>
</body>

</html>