<?php
include "../../config.php";
session_start();

$id = $_GET['id'];
$sql = "SELECT f.id, f.deskripsi, f.nama, f.harga, GROUP_CONCAT(DISTINCT g.gambar SEPARATOR ', ') as gambar, rating, GROUP_CONCAT(DISTINCT t.nama SEPARATOR ', ') AS tag, COUNT(DISTINCT r.id) as review FROM furniture f join furniture_gambar g on f.id = g.furniture_id LEFT JOIN review r ON f.id = r.furniture_id LEFT JOIN furniture_tag ft ON f.id = ft.furniture_id LEFT JOIN tag t ON ft.tag_id = t.id WHERE f.id = $id GROUP BY f.id, f.nama, f.harga";

$result = mysqli_query($conn, $sql);

if ($result) {
	$_SESSION['product'] = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
}

if (isset($_POST['btnAddToCart'])) {
	$sqlC = "INSERT INTO cart (id, user_id, furniture_id, quantity) VALUES (NULL, " . $_SESSION['id_user'] . ", $id, " . $_POST['quantity'] . ")";
	$resultC = mysqli_query($conn, $sqlC);


	if ($resultC) {
		header("Location: ../cart");
	}
}

$_SESSION['product']['gambar'] = array_map('trim', explode(',', $_SESSION['product']['gambar']));
$_SESSION['product']['tag'] = array_map('trim', explode(',', $_SESSION['product']['tag']));

$userId = $_SESSION['id_user'];
$sqlReview = "SELECT r.id, u.username, u.gambar, r.ulasan, r.rate, GROUP_CONCAT(rg.gambar SEPARATOR ', ') AS gambar FROM review r JOIN pesanan_item pi ON r.pesanan_item_id = pi.id JOIN pesanan p ON pi.pesanan_id = p.id JOIN user u ON p.user_id = u.id JOIN review_gambar rg ON r.id = rg.review_id WHERE u.id = $userId AND r.furniture_id = $id GROUP BY r.id;";
$resultReview = mysqli_query($conn, $sqlReview);

if ($resultReview) {
	$reviews = mysqli_fetch_all($resultReview, MYSQLI_ASSOC);
}

$reviews = array_map(function ($review) {
	$review['gambar'] = array_map('trim', explode(',', $review['gambar']));
	return $review;
}, $reviews);
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
					<div class="thumbnail-container max-w-[450px] overflow-auto" style="display: flex; gap: 15px; margin-top: 10px; cursor: pointer;">
						<?php foreach ($_SESSION['product']['gambar'] as $key => $value) { ?>
							<img src="../../img/upload/<?= $value ?>" class="thumbnail" alt="" class="slide" style="width: 80px; height: 80px; object-fit: cover;">
						<?php } ?>
					</div>
				</div>
				<div class="right">
					<div class="product">
						<h3 class="title"><?= $_SESSION['product']['nama'] ?></h3>
						<div class="sells">
							<img class="w-[15px] h-[15px]" src="../../img/star.png" alt="">
							<p id="rating"><?= $_SESSION['product']['rating'] ?></p>
							<p>|</p>
							<p><?= $_SESSION['product']['review'] ?> reviews</p>
						</div>
					</div>
					<div class="deskripsi">
						<div class="prc1">
							<h1 id="price">Rp.<?= number_format($_SESSION['product']['harga'], 0, ',', '.') ?></h1>
						</div>
						<div class="flex flex-wrap gap-2">
							<?php foreach ($_SESSION['product']['tag'] as $tag) { ?>
								<span class="bg-[#EFE7E2] text-[#B5733A] px-3 py-1 rounded-full text-sm transition">
									<?= $tag ?>
								</span>
							<?php } ?>
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

	<div class="mx-24 mb-24 flex flex-col gap-5">
		<h1 class="text-2xl font-medium">Reviews</h1>
		<?php foreach ($reviews as $data) { ?>
			<div class="flex flex-col gap-2">
				<hr class="mb-5">
				<div class="flex items-center gap-2">
					<img class="w-[50px] h-[50px] rounded-full" src="../../img/default_pp.png" alt="">
					<div>
						<p><?= $data['username'] ?></p>
						<div class="flex items-center gap-2">
							<img class="w-[20px] h-[20px]" src="../../img/star.png" alt="">
							<p><?= $data['rate'] ?></p>
						</div>
					</div>
				</div>
				<p><?= $data['ulasan'] ?></p>
				<div class="flex items-center gap-2">
					<?php foreach ($data['gambar'] as $img) { ?>
						<img class="w-[100px] h-[100px] object-cover rounded-lg" src="../../img/upload/<?= $img ?>" alt="">
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>

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