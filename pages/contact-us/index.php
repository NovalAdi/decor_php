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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body class="font-sans">

    <?php include "../../components/nav.php"; ?>

    <!-- contact us -->
    <section class="flex justify-center py-24 gap-10 items-center bg-[#F0E7E1]">
        <div class="w-[50%] flex justify-center">
            <div class="w-min flex flex-col gap-4">
                <h1 class="font-medium text-6xl">Contact Us</h1>
                <p class="text-gray-600">Email, call, or complete the form to learn <br> how Decor
                    can
                    fix your interior design problem.</p>
                <p class="text-gray-600">Decor@gmail.com</p>
                <p class="text-gray-600">(+032) 3456 7890</p>
                <a class="underline w-fit" href="">Customer Support</a>
                <div class="flex gap-5 mt-6">
                    <div class="w-[250px] flex flex-col gap-2">
                        <h2>Feedback and Suggestions</h2>
                        <p class="text-gray-600">We value your feedback and are continuously working to improve Decor.
                            Your
                            input is crucial in
                            shaping the future of Decor.</p>
                    </div>
                    <div class="w-[250px] flex flex-col gap-2">
                        <h2>Customer Support</h2>
                        <p class="text-gray-600">Our support team is available around the clock to address any concerns
                            or
                            queries you may have.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-[50%] py-10 pl-16 bg-[url('../../img/jp-2.png')] rounded-l-xl">
            <form action="" class="w-min bg-white p-7 rounded-lg">
                <h1 class="text-4xl">Get in Touch</h1>
                <p class="text-gray-600">You can reach us anytime</p>
                <div class="flex gap-3 mt-3">
                    <input type="text" placeholder="First name"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-lg">
                    <input type="text" placeholder="Last name"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-lg">
                </div>
                <div class="flex flex-col relative mt-3 w-full">
                    <input type="email" placeholder="Email"
                        class="pl-10 p-2 border border-[1.5px] border-gray-400 rounded-lg">
                    <i class="fa-solid fa-envelope h-full absolute left-3 flex items-center text-gray-400"></i>
                </div>
                <div class="flex mt-3">
                    <select name="" id="" class="p-2 border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg">
                        <option value="">+62</option>
                        <option value="">+63</option>
                        <option value="">+64</option>
                    </select>
                    <input type="text" placeholder="Phone number"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-r-lg w-full">
                </div>
                <textarea placeholder="How can we help?"
                    class="mt-3 min-w-full h-[200px] resize-none p-2 border border-[1.5px] border-gray-400 rounded-lg"
                    name="" id=""></textarea>
                <button type="submit" class="mt-3 w-full text-white py-2 rounded-lg bg-[#B5733A]">Submit</button>
                <p class="mt-3 self-center text-sm text-center text-gray-600">By contacting us, you agree to our <br> <b
                        class="text-black">Terms of
                        service</b> and
                    <b class="text-black">Privacy Policy</b>
                </p>
            </form>
        </div>
    </section>

    <!-- map -->
    <section class="flex gap-16 z-2 relative pb-10 pt-20 pl-24">
        <div class="h-[450px] w-[45%] drop-shadow-lg rounded-lg relative" id="map" class="z-2"></div>
        <div class="flex flex-col justify-center">
            <p class="text-xl">Our Location</p>
            <h1 class="text-4xl font-medium mt-4">Connecting Near and Far</h1>
            <h2 class="text-2xl mt-4 font-medium">Headquarters</h2>
            <div class="mt-3 flex flex-col gap-2">
                <p class="text-gray-500">Pt Decor (Telkom University)</p>
                <p class="text-gray-500">Jl. Telekomunikasi No. 1</p>
                <p class="text-gray-500">Buahbatu - Bojongsoang</p>
                <p class="text-gray-500">Bandung</p>
                <p class="text-gray-500">Jawa Barat 40257</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-20 flex">
        <div class="w-[40%] pl-24 pr-20 flex flex-col gap-3 pt-4">
            <h1 class="text-xl">FAQ</h1>
            <h1 class="text-5xl font-medium">Do you have <br>any question <br>for us?</h1>
            <p class="mt-3">If there are question you want to ask. We will answer all your question.</p>
            <div class="flex gap-3">
                <div class="flex flex-col relative mt-3 w-full">
                    <input type="email" placeholder="Enter your email"
                        class="pl-10 p-2 border border-[1.5px] border-gray-400 rounded-lg">
                    <i class="fa-solid fa-envelope h-full absolute left-3 flex items-center text-gray-400"></i>
                </div>
                <button type="submit" class="mt-3 px-3 w-min text-white py-2 rounded-lg bg-[#B5733A]">Submit</button>
            </div>
        </div>
        <div class="w-[60%] pr-24 flex flex-col gap-3">
            <div class="flex items-center justify-between h-[60px] hover:bg-gray-100 px-5 rounded-lg">
                <h1 class="font-medium text-md">What makes Decor better from other furniture and interior design
                    providers?</h1>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class="h-[1.5px] bg-gray-300"></div>
            <div class="flex items-center justify-between h-[60px] hover:bg-gray-100 px-5 rounded-lg">
                <h1 class="font-medium text-md">Can Decor help me design a space that reflects my personal style?</h1>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class="h-[1.5px] bg-gray-300"></div>
            <div class="flex items-center justify-between h-[60px] hover:bg-gray-100 px-5 rounded-lg">
                <h1 class="font-medium text-md">What makes Decor better from other furniture and interior design
                    providers?</h1>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class="h-[1.5px] bg-gray-300"></div>
            <div class="flex items-center justify-between h-[60px] hover:bg-gray-100 px-5 rounded-lg">
                <h1 class="font-medium text-md">Are Decor's products eco-friendly and sustainable?</h1>
                <i class="fa-solid fa-caret-down"></i>
            </div>
            <div class="h-[1.5px] bg-gray-300"></div>
            <div class="flex items-center justify-between h-[60px] hover:bg-gray-100 px-5 rounded-lg">
                <h1 class="font-medium text-md">What additional services does Decor offer besides furniture sales?</h1>
                <i class="fa-solid fa-caret-down"></i>
            </div>
        </div>
    </section>

    <!-- banner -->
    <section class="bg-[url('../../img/indus-2.jpg')] bg-center bg-no-repeat bg-cover h-[450px]">
        <div class="bg-gray-900/40 w-full h-full flex justify-center items-center">
            <h1 class="tracking-wider text-5xl font-bold text-white text-center leading-[4rem]">Make Your Dream Home
                Come True<br> With <span class="text-[#d18847] ">Decor</span></h1>
        </div>
    </section>

    <?php include "../../components/footer.php" ?>

    <script src="./script.js"></script>
</body>

</html>