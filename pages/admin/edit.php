<?php
include "../../config.php";
session_start();

// Cek apakah ada ID produk yang dikirimkan
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ambil data produk berdasarkan ID
    $sql = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    // Proses update data produk jika form disubmit
    if (isset($_POST['submit'])) {
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $desk = $_POST['desk'];

        // Update data produk di database
        $update_sql = "UPDATE produk SET nama = '$nama', harga = '$harga', desk = '$desk' WHERE id = $id";
        if (mysqli_query($conn, $update_sql)) {
            header("Location: index.php"); // Redirect ke halaman daftar produk setelah berhasil update
        } else {
            echo "Error updating product: " . mysqli_error($conn);
        }
    }
} else {
    echo "Product ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans">
    <?php include "../../components/nav.php"; ?>

    <section class="flex flex-col mt-24 mx-20">
        <h1 class="text-3xl font-bold">Edit Product</h1>

        <!-- Formulir Edit Produk -->
        <form method="POST" class="space-y-4 mt-4">
            <label class="block">
                <span class="text-gray-700">Product Name</span>
                <input type="text" name="nama" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="<?php echo $product['nama']; ?>" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Price</span>
                <input type="number" name="harga" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="<?php echo $product['harga']; ?>" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Description</span>
                <input type="text" name="desk" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="<?php echo $product['desk']; ?>" required>
            </label>

            <button type="submit" name="submit" class="inline-block bg-green-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Product</button>
        </form>
    </section>
</body>
</html>
