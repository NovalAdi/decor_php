<?php
include "../../config.php";
session_start();

if (isset($_POST['btnSearch']) || isset($_POST['btnFilter'])) {
    // Menyimpan search dan filter ke session
    if (isset($_POST['search_query'])) {
        $_SESSION['search_query'] = $_POST['search_query'];
    }

    if (isset($_POST['tags'])) {
        $_SESSION['filter_tags'] = $_POST['tags'];
    } else {
        unset($_SESSION['filter_tags']);  // Jika tidak ada filter tags, hapus
    }

    if (isset($_POST['ratings'])) {
        $_SESSION['filter_ratings'] = $_POST['ratings'];
    } else {
        unset($_SESSION['filter_ratings']);  // Jika tidak ada filter ratings, hapus
    }

    if (isset($_POST['price_from']) && isset($_POST['price_to'])) {
        $_SESSION['filter_price_from'] = $_POST['price_from'];
        $_SESSION['filter_price_to'] = $_POST['price_to'];
    } else {
        unset($_SESSION['filter_price_from'], $_SESSION['filter_price_to']);  // Jika tidak ada filter harga, hapus
    }

    // Menyiapkan query SQL dasar
    $sql = "
        SELECT p.id, p.nama, p.desk, p.harga, p.rating, GROUP_CONCAT(t.nama) AS tags 
        FROM produk p 
        LEFT JOIN produk_tag pt ON p.id = pt.id_produk 
        LEFT JOIN tag t ON pt.id_tag = t.id 
    ";

    $conditions = [];

    // Apply search query
    if (!empty($_SESSION['search_query'])) {
        $conditions[] = "p.nama LIKE '%" . $_SESSION['search_query'] . "%'";
    }

    // Apply tags filter
    if (!empty($_SESSION['filter_tags'])) {
        $tagList = array_map(function ($tag) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $tag) . "'";
        }, $_SESSION['filter_tags']);
        $conditions[] = "t.nama IN (" . implode(",", $tagList) . ")";
    }

    // Apply rating filter
    if (!empty($_SESSION['filter_ratings'])) {
        $ratingList = array_map('intval', $_SESSION['filter_ratings']);
        $conditions[] = "p.rating IN (" . implode(",", $ratingList) . ")";
    }

    // Apply price filter
    if (!empty($_SESSION['filter_price_from']) && !empty($_SESSION['filter_price_to'])) {
        $price_from = intval($_SESSION['filter_price_from']);
        $price_to = intval($_SESSION['filter_price_to']);
        $conditions[] = "(p.harga BETWEEN $price_from AND $price_to)";
    }

    // Gabung kondisi WHERE jika ada
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    // Tetap group by
    $sql .= " GROUP BY p.id, p.nama, p.desk, p.harga, p.rating;";

    // Eksekusi query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['products'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($_SESSION['products'] as &$product) {
            if (isset($product['tags'])) {
                $product['tags'] = explode(',', $product['tags']);
            }
        }
        unset($product);
    }
}


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
    <link rel="stylesheet" href="../home/style.css">
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

    <section class="grid grid-cols-4 pb-20 pt-10 mt-20">
        <!-- filter -->
        <aside class="flex flex-col p-10 gap-3 drop-shadow-md bg-white ml-14 mr-7 rounded-xl border border-[1px] border-gray-200 h-min">
            <form method="post">
                <h1 class="text-2xl font-medium">Filter</h1>
                <div>
                    <h1 class="font-medium">Tags</h1>
                    <div class="ml-2 text-gray-700 mt-3">
                        <?php
                        foreach ($_SESSION['tags'] as $tag) {
                            // Periksa jika tag ada di filter yang disimpan di session
                            $checked = (isset($_SESSION['filter_tags']) && in_array($tag['nama'], $_SESSION['filter_tags'])) ? 'checked' : '';
                        ?>
                            <div class="flex gap-3 items-center">
                                <input type="checkbox" name="tags[]" value="<?= $tag['nama'] ?>" <?= $checked ?>>
                                <p><?= $tag['nama'] ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div>
                    <h1 class="font-medium">Rating</h1>
                    <div class="ml-2 text-gray-700 mt-3 flex flex-col gap-1">
                        <?php
                        $ratings = [5, 4, 3, 2, 1];
                        foreach ($ratings as $rating) {
                            // Periksa jika rating ada di filter yang disimpan di session
                            $checked = (isset($_SESSION['filter_ratings']) && in_array($rating, $_SESSION['filter_ratings'])) ? 'checked' : '';
                        ?>
                            <div class="flex gap-3 items-center">
                                <input type="checkbox" name="ratings[]" value="<?= $rating ?>" <?= $checked ?>>
                                <div class="flex gap-1 items-center">
                                    <?php for ($i = 0; $i < $rating; $i++) { ?>
                                        <img class="w-[15px] h-[15px]" src="../../img/star.png" alt="">
                                    <?php } ?>
                                    <p>(<?= $rating ?>)</p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <h1 class="font-medium">Filter by Price</h1>
                    <div class="flex">
                        <input type="text" name="price_from" placeholder="From"
                            class="p-2 border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg text-sm w-full"
                            value="<?= isset($_SESSION['price_from']) ? $_SESSION['price_from'] : '' ?>">
                        <p class="flex items-center border border-[1.5px] border-gray-400 rounded-r-lg px-2">Rp</p>
                    </div>
                    <div class="flex">
                        <input type="text" name="price_to" placeholder="To"
                            class="p-2 border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg text-sm w-full"
                            value="<?= isset($_SESSION['price_to']) ? $_SESSION['price_to'] : '' ?>">
                        <p class="flex items-center border border-[1.5px] border-gray-400 rounded-r-lg px-2">Rp</p>
                    </div>
                </div>
                <input type="submit" name="btnFilter" class="mt-3 w-full text-white py-2 rounded-lg bg-[#B5733A]" value="Apply Filter">
            </form>
        </aside>



        <main class="col-span-3 mr-14">

            <!-- sort -->
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-medium">Show 12 product</h1>
                <div class="flex items-center gap-3">
                    <p>Sort by</p>
                    <select class="px-2 py-1 border border-[1.5px] border-gray-400 rounded-lg text-sm">
                        <option value="">Price</option>
                        <option value="">Rating</option>
                    </select>
                </div>
            </div>

            <!-- list -->
            <section class=" grid grid-cols-4 gap-3 mt-5">
                <?php
                foreach ($_SESSION['products'] as $product) { ?>
                    <a class="bg-white hover:bg-gray-50 overflow-hidden flex flex-col gap-3 rounded-lg" href="/detail-product2/">
                        <div class="relative">
                            <img class="bg-gray-200 h-[250px] object-contain" src="../../img/bed.png" alt="">
                            <div class="flex gap-2 items-center absolute left-2 bottom-2">
                                <img src="/img/ikea.svg" class="w-[40px]" alt="">
                            </div>
                        </div>
                        <div class="flex flex-col justify-between gap-2 h-full px-4 pb-2">
                            <div>
                                <h1 class="w-full line-clamp-2"><?= $product['nama'] ?></h1>
                                <p class="font-bold mt-2">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <img class="w-[15px] h-[15px]" src="../../img/star.png" alt="">
                                <p class=""><?= $product['rating'] ?> | 42 reviews</p>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </section>

            <!-- pagination -->
            <div class="flex gap-14 items-center text-lg mt-10 justify-center">
                <div class="flex gap-5">
                    <a href=""><i class="fa-solid fa-angles-left"></i></a>
                    <a href=""><i class="fa-solid fa-angle-left"></i></a>
                </div>
                <div class="flex gap-3">
                    <a href="" class="underline underline-offset-8">1</a>
                    <a href="">2</a>
                    <a href="">3</a>
                    <a href="">4</a>
                    <a href="">5</a>
                    <a href="">...</a>
                    <a href="">25</a>
                </div>
                <div class="flex gap-5">
                    <a href=""><i class="fa-solid fa-angle-right"></i></a>
                    <a href=""><i class="fa-solid fa-angles-right"></i></a>
                </div>
            </div>
        </main>
    </section>

    <!-- banner -->
    <section class="grid grid-cols-2 gap-10 px-16 mb-20">
        <div class="bg-[url('../../img/indus-2.jpg')] bg-center bg-no-repeat bg-cover h-[200px] rounded-xl overflow-hidden">
            <div class="bg-gray-900/30 w-full h-full flex justify-center items-center p-20">
                <h1 class="tracking-wider text-3xl font-bold text-white text-center">Checkout our Industial collection
                </h1>
            </div>
        </div>
        <div class="bg-[url('../../img/sc-2.webp')] bg-center bg-no-repeat bg-cover h-[200px] rounded-xl overflow-hidden">
            <div class="bg-gray-900/30 w-full h-full flex justify-center items-center p-20">
                <h1 class="tracking-wider text-3xl font-bold text-white text-center">Checkout our Scandinavian
                    collection</h1>
            </div>
        </div>
    </section>

    <?php include "../../components/footer.php" ?>

    <script src="../home/script.js"></script>
</body>

</html>