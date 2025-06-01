<?php
session_start();
include "../../config.php";

if (isset($_POST['btnSubmit'])) {
    $idFurniture = $_POST['id_produk'];
    $idPesananItem = $_GET['id'];
    $rate = $_POST['rating'];
    $ulasan = $_POST['ulasan'];
    $gambar = $_FILES['gambar'];

    $sqlInsert = "INSERT INTO review (furniture_id, pesanan_item_id, rate, ulasan, created_at) VALUES ($idFurniture, $idPesananItem, '$rate', '$ulasan', current_timestamp())";
    $resultInsert = mysqli_query($conn, $sqlInsert);

    if ($resultInsert) {
        $review_id = mysqli_insert_id($conn);

        foreach ($gambar['name'] as $key => $name) {
            $typeAllowed = ["image/jpeg", "image/png"];

            if (in_array($gambar["type"][$key], $typeAllowed)) {
                if (move_uploaded_file($gambar["tmp_name"][$key], "../../img/upload/" . basename($gambar["name"][$key]))) {

                    $sql = "INSERT INTO `review_gambar` (`id`, `review_id`, `gambar`) VALUES (NULL, $review_id, '$name')";
                    mysqli_query($conn, $sql);
                }
            }
        }

        

        header("Location: ../home");
    }
}
