<?php
include "../../config.php";
session_start();
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
    <link rel="stylesheet" href="style.css">
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

    <?php include "../../components/nav.php"; ?>

    <!-- header -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center px-6 sm:px-8 md:px-14 justify-center py-16 sm:py-20 md:py-32 md:h-[100vh] max-w-[95%] sm:max-w-[90%] md:max-w-[80%] mx-auto mt-10 sm:mt-16">
        <div class="bg-[#F0E7E1] p-4 sm:p-5 rounded-[20px] sm:rounded-[30px] flex items-center justify-center shadow-lg order-1 md:order-none">
            <img class="w-[250px] sm:w-[300px] md:w-[450px]" src="<?= IMG_PATH ?>header.png" alt="Decor Header">
        </div>
        <div class="flex flex-col gap-4 sm:gap-6 md:gap-7 items-start order-none md:order-1">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#B5733A] leading-[2rem] sm:leading-[2.5rem] md:leading-[3rem] tracking-wide">
                The Best Choice for a Home That Feels Like You
            </h1>
            <article class="text-sm sm:text-base md:text-base text-gray-700">
                From sleek minimalism to cozy accents, we offer solutions that turn houses into homes. Because great design should be effortless.
            </article>
            <button class="rounded py-2 px-4 sm:px-6 bg-[#B5733A] text-white hover:bg-[#9a5e2e] transition-all">
                Explore Our Shop
            </button>
        </div>
    </section>

    <!-- Partner -->
    <section class="flex flex-col items-center gap-7">
        <h1 class="text-xl">Assets From</h1>
        <div class="flex gap-14 md:gap-20 justify-center">
            <img width="130px"
                src="https://cloud.shopback.com/c_fit,h_750,w_750/store-service-id/assets/17217/d41ea290-9d52-11ed-90cf-3185466d5721.png"
                alt="">
            <img width="130px"
                src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Ikea_logo.svg/2560px-Ikea_logo.svg.png"
                alt="">
        </div>
    </section>

    <!-- why us -->
    <section class="bg-[#F0E7E1] flex justify-center w-full py-10 mt-24">
        <section
            class="flex-col lg:flex-row flex gap-16 items-center justify-center w-[90%] lg:w-[80%]">
            <img class="hidden lg:block w-[300px] lg:w-[350px]" src="<?= IMG_PATH ?>Group_15.svg" alt="">
            <div class="flex flex-col gap-6">
                <div class="flex gap-8">
                    <img class="block lg:hidden w-[200px] lg:w-[250px]" src="<?= IMG_PATH ?>Group_15.svg" alt="">
                    <div class="flex flex-col gap-6">
                        <h1 class="text-2xl sm:text-4xl font-medium text-[#B5733A]">Why Us?</h1>
                        <p class="text-sm sm:text-base text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. In, temporibus magnam cum sunt ipsa facilis neque autem dolorum dolorem, adipisci aperiam ipsam deserunt eaque nesciunt voluptatem libero incidunt et beatae.</p>
                    </div>
                </div>
                <div>
                    <h1 class="font-bold text-base sm:text-lg">Designer Art</h1>
                    <p class="ml-3 mt-2 text-sm sm:text-base text-gray-700">There are many variations of passages of lorem ipsum available, but the majority have suffered alteration in some form.</p>
                </div>
                <div>
                    <h1 class="font-bold text-base sm:text-lg">High Quality</h1>
                    <p class="ml-3 mt-2 text-sm sm:text-base text-gray-700">There are many variations of passages of lorem ipsum available, but the majority have suffered alteration in some form.</p>
                </div>
                <div>
                    <h1 class="font-bold text-base sm:text-lg">Branded Product</h1>
                    <p class="ml-3 mt-2 text-sm sm:text-base text-gray-700">There are many variations of passages of lorem ipsum available, but the majority have suffered alteration in some form.</p>
                </div>
            </div>
        </section>
    </section>

    <!-- stats -->
    <section class="flex w-full items-stretch justify-evenly mt-24">
        <div class="flex flex-col gap-2 h-[150px] w-[250px] justify-center items-center">
            <h1 class="text-3xl sm:text-5xl font-medium text-[#B5733A]">50+</h1>
            <p class="sm:text-xl">Designer</p>
        </div>
        <div class="w-[2px] bg-[#B5733A]"></div>
        <div class="flex flex-col gap-2 h-[150px] w-[250px] justify-center items-center">
            <h1 class="text-3xl sm:text-5xl font-medium text-[#B5733A]">200+</h1>
            <p class="sm:text-xl text-center">Furniture Collection</p>
        </div>
        <div class="w-[2px] bg-[#B5733A]"></div>
        <div class="flex flex-col gap-2 h-[150px] w-[250px] justify-center items-center">
            <h1 class="text-3xl sm:text-5xl font-medium text-[#B5733A]">100+</h1>
            <p class="sm:text-xl mx-2 text-center">Happy Customer</p>
        </div>
    </section>

    <!-- Kategories -->
    <section class="flex justify-center">
        <div
            class="mt-24 text-3xl max-[1025px]:text-2xl grid grid-cols-4 max-[426px]:grid-cols-1 items-center max-[1025px]:w-[80%] w-[70%] gap-5 md:gap-5">
            <div class="flex flex-col gap-3 h-full justify-between bg-[#F0E7E1] sm:row-span-2 rounded-lg">
                <h1 class="text-[#B5733A] mt-7 ml-5 overflow-hidden font-medium max-[1025px]:text-xl">Wardrobe</h1>
                <img class="self-center mb-14 sm:w-[218px] max-[426px]:h-[150px]" src="<?= IMG_PATH ?>wardrobe.png" alt="">
            </div>
            <div class="flex flex-col items-start gap-3 h-full bg-[#F0E7E1] rounded-lg bg-[#F0E7E1]">
                <h1 class="text-[#B5733A] mt-7 ml-5 overflow-hidden font-medium">Sofa</h1>
                <img class="self-center sm:w-[200px] max-[426px]:h-[150px]" src="<?= IMG_PATH ?>sofa-single.png" alt="">
            </div>
            <div class="flex flex-col items-start gap-3 h-full bg-[#F0E7E1] rounded-lg sm:col-span-2">
                <h1 class="text-[#B5733A] mt-7 ml-5 overflow-hidden font-medium">Table</h1>
                <img class="self-center sm:w-[4250px] max-[426px]:h-[150px]" src="<?= IMG_PATH ?>table.png" alt="">
            </div>
            <div class="flex flex-col items-start gap-3 h-full bg-[#F0E7E1] rounded-lg sm:col-span-2">
                <h1 class="text-[#B5733A] mt-7 ml-5 overflow-hidden font-medium">Bed</h1>
                <img class="self-center sm:w-[406px] mb-3 max-[426px]:h-[150px]" src="<?= IMG_PATH ?>bed.png" alt="">
            </div>
            <div class="flex flex-col items-start gap-3 h-full bg-[#F0E7E1] rounded-lg bg-[#F0E7E1]">
                <h1 class="text-[#B5733A] mt-7 ml-5 overflow-hidden font-medium">Lamp</h1>
                <img class="self-center sm:w-[121px] mb-3 max-[426px]:h-[150px]" src="<?= IMG_PATH ?>lamp.png" alt="">
            </div>
        </div>
    </section>

    <!-- review -->
    <section class="flex flex-col items-center my-32">
        <div class="flex flex-col w-[80%] sm:w-[70%] gap-7">
            <h1 class="self-center text-3xl sm:text-4xl text-[#B5733A] font-medium mb-2">What Client Say</h1>
            <div class="flex gap-3 sm:gap-7 items-center">
                <span class="text-[4rem]">"</span>
                <h1 class="font-medium text-sm sm:text-xl text-center italic">Decor.com is a modern online platform
                    catering to
                    those seeking
                    high-quality interior furniture with a focus on stylish and functional design. The website offers an
                    extensive range of pieces for various spaces, including living rooms, bedrooms, and offices, with a
                    strong emphasis on modern and minimalist aesthetics.</h1>
                <span class="text-[4rem]">"</span>
            </div>
            <div class="flex justify-center items-center gap-7">
                <div class="flex justify-center items-center gap-3">
                    <img class="rounded-[100%] h-[30px] sm:h-[40px]" src="<?= IMG_PATH ?>default_pp.png" alt="">
                    <h1 class="text-sm sm:text-lg">John Doe</h1>
                </div>
                <div class="w-[2px] h-[40px] bg-black"></div>
                <h1 class="text-sm sm:text-base text-gray-600">The Famous John Doe</h1>
            </div>
        </div>
    </section>

    <?php include "../../components/footer.php" ?>

</body>

</html>