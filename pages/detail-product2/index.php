<?php
include "../../config.php";
session_start();

$id = $_GET['id'];
$sql = "SELECT p.id, p.nama, p.desk, p.gambar, p.harga, p.rating, GROUP_CONCAT(t.nama) AS tags FROM produk p LEFT JOIN produk_tag pt ON p.id = pt.id_produk LEFT JOIN tag t ON pt.id_tag = t.id WHERE p.id='$id' GROUP BY p.id, p.nama, p.desk, p.harga, p.rating;";

$result = mysqli_query($conn, $sql);

if ($result) {
	$_SESSION['product'] = mysqli_fetch_all($result, MYSQLI_ASSOC)[0];
}

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

	<section class="detail mt-24">
		<div class="box flexx">
			<div class="left">
				<div class="main-img">
					<img  src="../../img/upload/<?= $_SESSION['product']['gambar'] ?>" alt="" class="slide">
				</div>
				<div class="option flex">
					<img src="../../img/sofa.png" alt="">
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
						<p id="detail"><?= $_SESSION['product']['desk'] ?></p>
					</div>

					<!-- <h5>Color - Lightgrey</h5>
					<div class="color flexx">
						<span></span>
						<span></span>
						<span></span>
					</div> -->
				</div>
			</div>
			<div class="middle">
				<div class="checkout-sect">
					<h1>Atur Jumlah</h1>
					<div class="stock">
						<h5 class="mt-2">Quantity</h5>
					</div>
					<div class="flex gap-2 mb-5 mt-2">
						<button class="w-[30px] p-1 border rounded-full border-1 text-center hover:bg-gray-200" onclick="minusCounter()">-</button>
						<input class="py-1 px-2 border rounded-full border-1 w-[50px] text-center bg-white" id="counter" type="text" disabled value="1" min="1">
						<button class="w-[30px] p-1 border rounded-full border-1 text-center hover:bg-gray-200" onclick="addCounter()">+</button>
					</div>
					<div class="total">
						<p id="total">Total</p>
						<input type="text" class="text-end" id="harga" disabled value="Rp.<?= number_format($_SESSION['product']['harga'], 0, ',', '.') ?>">
					</div>
					<button class="btn">Add To Cart</button>
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
		</div>
	</section>

	<?php include "../../components/footer.php" ?>

	<script src="script.js"></script>
</body>

</html>