<?php
include "../../config.php";
session_start();

// Cek apakah ada ID produk yang dikirimkan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus produk dari database
    $sql = "DELETE FROM produk WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // Redirect ke halaman daftar produk setelah berhasil menghapus
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "Product ID not provided.";
}
?>
