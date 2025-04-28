<?php
$host = "localhost";
$user = "root";
$password = "";

$dbname = "db_decor";
$conn = new mysqli($host, $user, $password, $dbname);
if (!$conn) {
    die(" Koneksi ke MY SQL gagal , silahkan koneksikan kembali ");
}

define('IMG_PATH', '../../img/');

?>