<?php
include "../../config.php";
session_start();

// Proses tambah produk jika form disubmit
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $desk = $_POST['desk'];
    $rating = $_POST['rating'];
    $stok = $_POST['stok'];
    $image = $_FILES['img'];

    $typeAllowed = ["image/jpg", "image/jpeg", "image/png"];
    $foto = ""; // Variabel untuk menyimpan nama gambar

    // Validasi tipe file
    if (in_array($image["type"], $typeAllowed)) {
        // Tentukan lokasi penyimpanan gambar
        $targetDir = "../../img/upload/";
        $targetFile = $targetDir . basename($image["name"]);

        // Pindahkan file gambar ke folder yang ditentukan
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            // Jika gambar berhasil di-upload
            $foto = $image["name"];
        } else {
            echo "Gagal meng-upload gambar.";
            exit();
        }
    }
    // Validasi input
    if (empty($nama) || empty($harga) || empty($desk)) {
        echo "Semua kolom harus diisi.";
    } else {
        // Query untuk menambahkan produk ke database
        $sql = "INSERT INTO produk (nama, harga, desk, stok, gambar, rating) VALUES ('$nama', '$harga', '$desk', '$rating', '$foto', '$stok')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php"); // Redirect ke halaman daftar produk setelah berhasil tambah
        } else {
            echo "Error adding product: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">
    <?php include "../../components/nav.php"; ?>

    <section class="flex flex-col mt-24 mx-20">
        <h1 class="text-3xl font-bold">Add New Product</h1>

        <!-- Formulir untuk menambah produk -->
        <form method="POST" class="space-y-4 mt-4" enctype="multipart/form-data">
            <label class="block">
                <span class="text-gray-700">Product Name</span>
                <input type="text" name="nama" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Price</span>
                <input type="number" name="harga" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Description</span>
                <input type="text" name="desk" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Rating</span>
                <input type="text" name="rating" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Stock</span>
                <input type="text" name="stok" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Image</span>
                <input type="file" name="img" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <button type="submit" name="submit" class="inline-block bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-700">Add Product</button>
        </form>
    </section>
</body>
</html>
