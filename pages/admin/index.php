<?php
include "../../config.php";
session_start();
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

    <section class="flex flex-col mt-24 mx-20">
        <style>
            .section-title {
                margin-bottom: 20px;
            }
        </style>
        <h1 class="text-3xl font-bold section-title">Your Products</h1>




        <table class="table-fixed">
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-white" style="background-color: #B5733A;">Image</th>
                    <th class="border px-4 py-2 text-white" style="background-color: #B5733A;">Name</th>
                    <th class="border px-4 py-2  text-white" style="background-color: #B5733A;">Price</th>
                    <th class="border px-4 py-2  text-white" style="background-color: #B5733A;">Description</th>
                    <th class="border px-4 py-2  text-white" style="background-color: #B5733A;">Rating</th>
                    <th class="border px-4 py-2  text-white" style="background-color: #B5733A;">Stock</th>
                    <th class="border px-4 py-2  text-white" style="background-color: #B5733A;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id, p.nama, p.desk, p.gambar, p.harga, p.rating, p.stok, GROUP_CONCAT(t.nama) AS tags FROM produk p LEFT JOIN produk_tag pt ON p.id = pt.id_produk LEFT JOIN tag t ON pt.id_tag = t.id GROUP BY p.id, p.nama, p.desk, p.harga, p.rating";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='border px-4 py-2 text-center'><img class='object-cover w-[60px] h-[60px] rounded-lg' src='../../img/upload/" . $row['gambar'] . "' alt=''></td>";
                    echo "<td class='border px-4 py-2'>" . $row['nama'] . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>Rp." . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td class='border px-4 py-2 max-w-[250px] truncate'>" . $row['desk'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['rating'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['stok'] . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>
                        <a href='edit.php?id=" . $row['id'] . "' class='text-blue-700'>Edit</a> |
                        <a href='delete.php?id=" . $row['id'] . "' class='text-red-700'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol Add Product di bawah tabel -->
        <div class="mt-4 flex justify-end">
            <a href="add.php" class="text-black-500 underline hover:text-orange-500">Add Product</a>
        </div>
    </section>

    <script src="../home/script.js"></script>
</body>

</html>