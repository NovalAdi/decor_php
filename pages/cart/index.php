<?php
include "../../config.php";
session_start();

$sql = "SELECT c.id, p.nama, p.gambar, p.harga, c.quantity FROM cart c JOIN produk p ON c.id_produk = p.id JOIN user u ON c.id_user = u.id WHERE u.id = " . $_SESSION['id_user'];
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
    <title>Cart</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/home/style.css">
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

    <section class="flex justify-center mt-32">
        <table class="w-[95%]">
            <thead align="left" class="bg-gray-100">
                <th class="py-3 pl-3">PRODUCT</th>
                <th>PRICE</th>
                <th>QUANTITY</th>
                <th>TOTAL</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['data'] as $key => $data) { ?>
                    <tr class="h-[90px] item-cart <?= $key % 2 == 0 ? 'bg-gray-50' : 'bg-gray-100' ?>">
                        <td>
                            <div class="flex items-center gap-3 pl-3">
                                <input type="checkbox" name="" id="">
                                <img class="object-cover w-[60px] h-[60px] rounded-lg" src="../../img/upload/<?= $data['gambar'] ?>" alt="">
                                <h1><?= $data['nama'] ?></h1>
                            </div>
                        </td>
                        <td>
                            <p>Rp.<?= number_format($data['harga'], 0, ',', '.') ?></p>
                        </td>
                        <td>
                            <div class="counter flex">
                                <button class="h-[30px] w-[30px] text-2xl bg-white justify-center items-center ">-</button>
                                <input type="text" class="w-[30px] text-center bg-gray-300" disabled value="<?= $data['quantity'] ?>" min="1">
                                <button
                                    class="h-[30px] w-[30px] text-2xl bg-white flex justify-center items-center">+</button>
                            </div>
                        </td>
                        <td>
                            <p>Rp.<?= number_format(($data['harga'] * $data['quantity']), 0, ',', '.')  ?></p>
                        </td>
                        <td>
                            <a href="">X</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
    <section class="flex justify-center mt-7 mb-32">
        <div class="flex justify-between w-[95%]">
            <button class="px-20 py-2 text-[#B5733A] font-medium rounded-full border-2 border-[#B5733A]">Use Promo
                Code</button>
            <a class="px-20 py-2 text-white font-medium rounded-full bg-[#B5733A] border-2 border-[#B5733A]"
                href="./checkout/">Checkout</a>
        </div>
    </section>

    <?php include "../../components/footer.php" ?>

    <script src="./script.js"></script>
</body>

</html>