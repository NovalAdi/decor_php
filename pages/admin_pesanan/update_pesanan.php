<?php
session_start();
include "../../config.php";

$status = $_POST['status'];
$id_pesanan = $_POST['id_pesanan'];

$sqlUpdate = "UPDATE pesanan SET status = '$status' WHERE id = $id_pesanan";
if (mysqli_query($conn, $sqlUpdate)) {
    header("Location: index.php");
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
