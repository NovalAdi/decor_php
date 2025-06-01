<?php
include "../../config.php";
session_start();

$sql = "SELECT f.id, f.nama, f.harga, g.gambar, rating, GROUP_CONCAT(DISTINCT t.nama SEPARATOR ', ') AS tag, COUNT(r.id) as review FROM furniture f LEFT JOIN review r ON f.id = r.furniture_id join furniture_gambar g on f.gambar_utama = g.id LEFT JOIN furniture_tag ft ON f.id = ft.furniture_id LEFT JOIN tag t ON ft.tag_id = t.id ";

$conditions = [];
$having = "";

if (isset($_POST['btnFilter']) || isset($_POST['sort_by'])) {
    $_SESSION['tag_filter'] = $_POST['tags'];
    $_SESSION['rating_filter'] = $_POST['ratings'];
    $_SESSION['price_from'] = $_POST['price_from'];
    $_SESSION['price_to'] = $_POST['price_to'];
}

if (isset($_POST['sort_by'])) {
    $_SESSION['sort_by'] = $_POST['sort_by'];
}

if (isset($_SESSION['tag_filter'])) {
    $tags = array_map(function ($tag) {
        return "'" . $tag . "'";
    }, $_SESSION['tag_filter']);

    $conditions[] = "t.nama IN(" . implode(',', $tags) . ")";
}

if (isset($_SESSION['rating_filter'])) {
    $having = "HAVING FLOOR(rating) IN (" . implode(',', $_SESSION['rating_filter']) . ")";
}

if (isset($_SESSION['search_query'])) {
    $conditions[] = "f.nama LIKE '%" . $_SESSION['search_query'] . "%'";
}

$price_conditions = [];

if (!empty($_SESSION['price_from'])) {
    $price_from = intval($_SESSION['price_from']);
    $price_conditions[] = "f.harga >= $price_from";
}

if (!empty($_SESSION['price_to'])) {
    $price_to = intval($_SESSION['price_to']);
    $price_conditions[] = "f.harga <= $price_to";
}

if (!empty($price_conditions)) {
    $conditions[] = implode(' AND ', $price_conditions);
}

if (count($conditions) != 0) {
    $sql .= "WHERE " . implode(' AND ', $conditions) . "";
}

$sql .= " GROUP BY f.id, f.nama, f.harga ";

if (!empty($having)) {
    $sql .= $having . " ";
}

if (isset($_SESSION['sort_by'])) {
    switch ($_SESSION['sort_by']) {
        case 'price_asc':
            $sql .= " ORDER BY f.harga ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY f.harga DESC";
            break;
        case 'rating_asc':
            $sql .= " ORDER BY f.rating ASC";
            break;
        case 'rating_desc':
            $sql .= " ORDER BY f.rating DESC";
            break;
    }
}

$sqltag = "SELECT * FROM tag";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
$resultTag = mysqli_query($conn, $sqltag);
$rowTag = mysqli_fetch_all($resultTag, MYSQLI_ASSOC);

$_SESSION['products'] = empty($row) ? [] : $row;
for ($i = 0; $i < 50; $i++) {
    $_SESSION['products'][] = [];
}
$_SESSION['tags'] = empty($rowTag) ? [] : $rowTag;

$dataPerPage = 20;

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

<body class="font-sans bg-gray-100">

    <?php include "../../components/nav.php"; ?>

    <section class="grid grid-cols-4 py-3 mt-20">
        <!-- filter -->
        <form method="post" class="flex flex-col py-10 px-6 gap-3 drop-shadow-md bg-white ml-14 mr-7 rounded-xl border border-[1px] border-gray-200 h-min">
            <h1 class="text-2xl font-medium mb-2">Filter</h1>
            <!-- tags -->
            <div>
                <h1 class="font-medium">Tags</h1>
                <div class="ml-2 text-gray-700 mt-3 flex flex-wrap gap-y-3 gap-x-2">
                    <?php
                    foreach ($_SESSION['tags'] as $tag) {
                        $checked = isset($_SESSION['tag_filter']) && in_array($tag['nama'], $_SESSION['tag_filter']) ? 'checked' : '';
                    ?>
                        <label class="cursor-pointer">
                            <input
                                type="checkbox"
                                name="tags[]"
                                value="<?= $tag['nama'] ?>"
                                <?= $checked ?>
                                class="peer hidden" />
                            <span class="peer-checked:bg-[#B5733A] peer-checked:text-white bg-[#EFE7E2] text-[#B5733A] hover:bg-[#e9d7cc] px-3 py-1 rounded-full text-sm transition">
                                <?= $tag['nama'] ?>
                            </span>
                        </label>

                    <?php } ?>
                </div>
            </div>
            <!-- rating  -->
            <div class="mt-3">
                <h1 class="font-medium">Rating</h1>
                <div class="ml-2 text-gray-700 mt-3 flex flex-col gap-1">
                    <?php
                    $ratings = [5, 4, 3, 2, 1];
                    foreach ($ratings as $rating) {
                        // Periksa jika rating ada di filter yang disimpan di session
                        $checked = (isset($_SESSION['rating_filter']) && in_array($rating, $_SESSION['rating_filter'])) ? 'checked' : '';
                    ?>
                        <label class="flex gap-3 items-center">
                            <input type="checkbox" name="ratings[]" value="<?= $rating ?>" <?= $checked ?>>
                            <div class="flex gap-1 items-center">
                                <?php for ($i = 0; $i < $rating; $i++) { ?>
                                    <img class="w-[15px] h-[15px]" src="../../img/star.png" alt="">
                                <?php } ?>
                                <p>(<?= $rating ?>)</p>
                            </div>
                        </label>
                    <?php } ?>
                </div>
            </div>
            <!-- price  -->
            <div class="flex flex-col gap-3 mt-3">
                <h1 class="font-medium">Filter by Price</h1>
                <div class="flex">
                    <p class="flex items-center border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg px-2">Rp</p>
                    <input type="text" name="price_from" placeholder="From"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-r-lg text-sm w-full"
                        value="<?= isset($_SESSION['price_from']) ? $_SESSION['price_from'] : '' ?>">
                </div>
                <div class="flex">
                    <p class="flex items-center border-l-[1.5px] border-y-[1.5px] border-gray-400 rounded-l-lg px-2">Rp</p>
                    <input type="text" name="price_to" placeholder="To"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-r-lg text-sm w-full"
                        value="<?= isset($_SESSION['price_to']) ? $_SESSION['price_to'] : '' ?>">
                </div>
            </div>
            <input type="submit" name="btnFilter" class="mt-3 w-full text-white py-2 rounded-lg bg-[#B5733A]" value="Apply Filter">
        </form>

        <main class="col-span-3 mr-14">

            <!-- sort -->
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-medium">Show <?= count($_SESSION['products']) ?> products</h1>
                <form method="post" class="flex items-center gap-3">
                    <p>Sort by</p>
                    <select name="sort_by" onchange="this.form.submit()" class="px-2 py-1 border border-[1.5px] border-gray-400 rounded-lg text-sm">
                        <option value="" <?= !isset($_SESSION['sort_by']) ? 'selected' : '' ?>>Select</option>
                        <option value="price_asc" <?= (isset($_SESSION['sort_by']) && $_SESSION['sort_by'] == 'price_asc') ? 'selected' : '' ?>>Price low to high</option>
                        <option value="price_desc" <?= (isset($_SESSION['sort_by']) && $_SESSION['sort_by'] == 'price_desc') ? 'selected' : '' ?>>Price high to low</option>
                        <option value="rating_asc" <?= (isset($_SESSION['sort_by']) && $_SESSION['sort_by'] == 'rating_asc') ? 'selected' : '' ?>>Rating low to high</option>
                        <option value="rating_desc" <?= (isset($_SESSION['sort_by']) && $_SESSION['sort_by'] == 'rating_desc') ? 'selected' : '' ?>>Rating high to low</option>
                    </select>
                </form>

            </div>

            <!-- list -->
            <section class=" grid grid-cols-4 gap-3 mt-5">
                <?php
                foreach ($_SESSION['products'] as $key => $product) {
                    $list = isset($_GET['list']) ? $_GET['list'] : 1;
                    if ($list != 1 && $key < ($list - 1) * $dataPerPage) {
                        continue;
                    } elseif ($list != 1 && $key >= $list * $dataPerPage) {
                        continue;
                    } elseif ($list == 1 && $key >= $dataPerPage) {
                        break;
                    } ?>
                    <a class="pb-1 bg-white hover:bg-gray-50 overflow-hidden flex flex-col gap-3 rounded-lg" href="../detail-product2/?id=<?= $product['id'] ?>">
                        <div class="relative">
                            <img class="bg-gray-200 h-[250px] object-cover" src="../../img/upload/<?= $product['gambar'] ?>" alt="">
                        </div>
                        <div class="flex flex-col justify-between gap-2 h-full px-4 pb-2">
                            <div>
                                <h1 class="w-full line-clamp-2"><?= $product['nama'] ?></h1>
                                <p class="font-bold mt-2">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <img class="w-[15px] h-[15px]" src="../../img/star.png" alt="">
                                <p class=""><?= $product['rating'] ?> | <?= $product['review'] ?> reviews</p>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </section>

            <!-- pagination -->
            <div class="flex gap-14 items-center text-lg mt-10 justify-center">
                <div class="flex gap-5">
                    <a href="?list=1"><i class="fa-solid fa-angles-left"></i></a>
                    <a href="?list=<?= isset($_GET['list']) && $_GET['list'] > 1 ? $_GET['list'] - 1 : 1 ?>"><i class="fa-solid fa-angle-left"></i></a>
                </div>
                <div class="flex gap-3">
                    <?php
                    $page = count($_SESSION['products']) % $dataPerPage == 0 ? count($_SESSION['products']) / $dataPerPage : floor(count($_SESSION['products']) / $dataPerPage + 1);
                    for ($i = 1; $i <= $page; $i++) {
                        $active = (isset($_GET['list']) && $_GET['list'] == $i) ? 'active' : '';
                        if ($active == 'active' || (!isset($_GET['list']) && $i == 1)) { ?>
                            <a href="?list=<?= $i ?>" class="underline underline-offset-8"><?= $i ?></a>
                        <?php } else { ?>
                            <a href="?list=<?= $i ?>"><?= $i ?></a>
                    <?php }
                    } ?>
                </div>
                <div class="flex gap-5">
                    <a href="?list=<?= isset($_GET['list']) && $_GET['list'] < floor(count($_SESSION['products']) / $dataPerPage + 1) ? $_GET['list'] + 1 : floor(count($_SESSION['products']) / $dataPerPage + 1) ?>"><i class="fa-solid fa-angle-right"></i></a>
                    <a href="?list=<?= floor(count($_SESSION['products']) / $dataPerPage + 1) ?>"><i class="fa-solid fa-angles-right"></i></a>
                </div>
            </div>
        </main>
    </section>

    <!-- banner -->
    <section class="grid grid-cols-2 gap-10 px-16 mb-20">
        <div class="bg-[url('../../img/indus-2.jpg')] bg-center bg-no-repeat bg-cover h-[200px] rounded-xl overflow-hidden">
            <div class="bg-gray-900/30 w-full h-full flex justify-center items-center p-20">
                <h1 class="tracking-wider text-3xl font-bold text-white text-center">Explore Our Exclusive Annual Sale
                </h1>
            </div>
        </div>
        <div class="bg-[url('../../img/jp-2.png')] bg-center bg-no-repeat bg-cover h-[200px] rounded-xl overflow-hidden">
            <div class="bg-gray-900/30 w-full h-full flex justify-center items-center p-20">
                <h1 class="tracking-wider text-3xl font-bold text-white text-center">Enjoy Big Discounts in Our Mid-Year Deals</h1>
            </div>
        </div>
    </section>

    <?php include "../../components/footer.php" ?>

    <script src="../home/script.js"></script>
</body>

</html>