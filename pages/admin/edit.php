<?php
include "../../config.php";
session_start();

// Cek apakah ada ID produk
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result); //naro data data yang diambil dari line 8-9

    // Jika form disubmit
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $desk = $_POST['desk'];
        $rating = $_POST['rating'];
        $stok = $_POST['stok'];
        $image = $_FILES['img']; //kaarena dia bentuk nya files yang name inputnya img
        $foto = $product['gambar']; // default gambar lama
        $typeAllowed = ["image/jpg", "image/jpeg", "image/png"]; //tipe file yang boleh diupload 

        // Cek apakah ada gambar baru diupload
        if (!empty($image["name"])) {
            if (in_array($image["type"], $typeAllowed)) {
                $targetDir = "../../img/upload/"; //untuk menyimpan gambar setelah upload
                $targetFile = $targetDir . basename($image["name"]); //menggabungkan variabel target dir dengan basename 

                if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                    $foto = $image["name"]; // replace gambar lama dengan yang baru
                } else {
                    echo "Gagal meng-upload gambar.";
                    exit();
                }
            }
        }

        // Update database
        $update_sql = "UPDATE produk 
                        SET nama = '$nama', harga = '$harga', desk = '$desk', rating = '$rating', stok = '$stok', gambar = '$foto' 
                       WHERE id = $id";

        if (mysqli_query($conn, $update_sql)) {
            header("Location: index.php");
        } else {
            echo "Gagal update produk: " . mysqli_error($conn);
        }
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans">
    <?php include "../../components/nav.php"; ?>

    <section class="flex flex-col my-24 mx-20">
        <h1 class="text-3xl font-bold">Edit Product</h1>

        <form method="POST" class="space-y-4 mt-4" enctype="multipart/form-data">
            <label class="block">
                <span class="text-gray-700">Product Name</span>
                <input type="text" name="nama" value="<?php echo $product['nama']; //naro data yang sudah diambil dari get produk awal?>"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Price</span>
                <input type="number" name="harga" value="<?php echo $product['harga']; ?>"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Description</span>
                <input type="text" name="desk" value="<?php echo $product['desk']; ?>"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Rating</span>
                <input type="text" name="rating" value="<?php echo $product['rating']; ?>"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Stock</span>
                <input type="text" name="stok" value="<?php echo $product['stok']; ?>"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Current Image</span><br>
                <img src="../../img/upload/<?php echo $product['gambar']; ?>" class="w-20 h-20 rounded-lg mt-2">
            </label>

            <label class="block">
                <span class="text-gray-700">Change Image (optional)</span>
                <input type="file" name="img" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
            </label>

            <input type="submit" name="submit" class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-blue-700"
                value="update produk">
        </form>
    </section>
</body>

</html>