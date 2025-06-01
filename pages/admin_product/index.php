<?php
include "../../config.php"; //untuk mengimpor file konfigurasi yang berisi koneksi ke database ($conn)
session_start(); //menyimpan data login user serta mengakses variabel global
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

    <?php include "../../components/nav.php"; //untuk tampilan navbar agar konsisten di halaman admin 
    ?>

    <section class="flex flex-col my-24 mx-20">
        <style>
            .section-title {
                margin-bottom: 20px;
            }
        </style>
        <h1 class="text-3xl font-bold section-title">Your Products</h1>

        <div class="w-[95%] flex justify-start">
            <a href="add.php" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                + Add Product
            </a>
        </div>

        <table class="table-fixed mt-5">
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
                $sql = "SELECT f.id, f.nama, f.deskripsi, f.stock, f.harga, g.gambar, IFNULL(ROUND(AVG(r.rate), 1), 0.0) AS rating FROM furniture f join furniture_gambar g on f.gambar_utama = g.id LEFT JOIN pesanan_item pi ON f.id = pi.furniture_id LEFT JOIN pesanan p ON p.id = pi.pesanan_id LEFT JOIN review r ON pi.id = r.pesanan_item_id LEFT JOIN furniture_tag ft ON f.id = ft.furniture_id GROUP BY f.id, f.nama, f.harga;"; //memilih semua kolom tabel tabel produk
                $result = mysqli_query($conn, $sql); //untuk melakukan checking apakah sql sudah berjalan atau belum 
                while ($row = mysqli_fetch_assoc($result)) {
                    //menampilkan baris tabel untuk setiap produk , melooping sesuai panjang data base 
                    echo "<tr>";
                    echo "<td class='border px-4 py-2 text-center'><img class='object-cover w-[60px] h-[60px] rounded-lg' src='../../img/upload/" . $row['gambar'] . "' alt=''></td>";
                    echo "<td class='border px-4 py-2'>" . $row['nama'] . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>Rp." . number_format($row['harga'], 0, ',', '.') . "</td>";
                    echo "<td class='border px-4 py-2 whitespace-nowrap overflow-hidden text-ellipsis max-w-[500px]'>" . $row['deskripsi'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['rating'] . "</td>";
                    echo "<td class='border px-4 py-2'>" . $row['stock'] . "</td>";
                    echo "<td class='border px-4 py-2 text-center'>
                        <a href='edit.php?id=" . $row['id'] . "' class='text-blue-700'>Edit</a> |
                        <a href='delete.php?id=" . $row['id'] . "' class='text-red-700'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <?php include "../../components/footer.php" ?>
</body>

</html>