<?php

session_start();     // Pastikan session dimulai
session_unset();     // Menghapus semua variabel di $_SESSION
session_destroy();   // Menghancurkan session di server

header('location: ../signin');

?>