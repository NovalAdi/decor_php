<?php
include "../../config.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
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
    <title>Document</title>
</head>

<body class="font-sans">
    <?php include "../../components/nav.php"; ?>

    <main class="my-24 mx-20 flex flex-col gap-4">
        <h1 class="text-2xl font-semibold">Judul judul judul</h1>
        <h1 class="text-xl font-semibold">Rp.000.000.000</h1>
        <h1 class="text-xl font-semibold">Tags</h1>
        <section class="flex gap-5">
            
        </section>
        <section class="flex gap-5 overflow-x-auto scrollbar-hide py-5">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
            <img class="w-[200px] h-[200px] object-cover border border-gray rounded-lg" src="../../img/upload/bed.png" alt="">
        </section>
        <h1 class="text-xl font-semibold">Deskripsi</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </main>

    <?php include "../../components/footer.php" ?>
</body>

</html>