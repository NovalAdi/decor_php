<?php
include "../../config.php";
session_start();

$sql = "SELECT p.id, p.nama, p.gambar, p.harga, p.rating, p.stok, GROUP_CONCAT(t.nama) AS tags FROM produk p LEFT JOIN produk_tag pt ON p.id = pt.id_produk LEFT JOIN tag t ON pt.id_tag = t.id GROUP BY p.id, p.nama, p.desk, p.harga, p.rating";

$result = mysqli_query($conn, $sql);

if ($result) {
    $_SESSION['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decor</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../home/style.css">
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
</head>

<body class="font-sans">

    <?php include "../../components/nav.php"; ?>

    <section class="flex flex-col items-center my-32 gap-5">
        <div class="w-[95%] flex justify-start">
            <a href="add.php" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                + Add Product
            </a>
        </div>
        <div class="w-[95%] overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead align="left" class="bg-gray-100">
                    <tr>
                        <th class="py-3 pl-3">Products</th>
                        <th>Price</th>
                        <th>Tags</th>
                        <th>Rating</th>
                        <th>Stocks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($_SESSION['data']) != 0) {
                        foreach ($_SESSION['data'] as $key => $data) { ?>
                            <tr class="h-[100px] <?= $key % 2 == 0 ? 'bg-gray-50' : 'bg-gray-100' ?>">
                                <td>
                                    <div class="flex items-center gap-3 pl-3">
                                        <img class="object-cover w-[60px] h-[60px] rounded-lg" src="../../img/upload/<?= $data['gambar'] ?>" alt="">
                                        <h1><?= $data['nama'] ?></h1>
                                    </div>
                                </td>
                                <td>
                                    <p>Rp.<?= number_format($data['harga'], 0, ',', '.') ?></p>
                                </td>
                                <td>
                                    <div class="flex flex-wrap gap-2 max-w-96">
                                        <?php
                                        $tags = explode(',', $data['tags']);
                                        foreach ($tags as $tag) { ?>
                                            <span class="bg-[#EFE7E2] text-[#B5733A] px-3 py-1 rounded-full text-sm"><?= $tag ?></span>
                                        <?php } ?>
                                    </div>
                                </td>
                                <td>
                                    <p class="flex gap-2 items-center"><img class="w-[15px] h-[15px]" src="../../img/star.png" alt=""><?= $data['rating'] ?></p>
                                </td>
                                <td>
                                    <p><?= $data['stok'] ?></p>
                                </td>
                                <td>
                                    <div class="flex justify-center items-center gap-2 mr-4">
                                        <a href="#" class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Edit</a>
                                        <a href="#" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr class="h-[90px] bg-gray-50">
                            <td colspan="5" class="text-center">Cart is Empty</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</body>

</html>