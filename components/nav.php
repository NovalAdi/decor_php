<?php
if (isset($_POST['btnSearch'])) {
    $_SESSION['search_query'] = $_POST['search_query'];
    header('Location: ../products');
}

if (isset($_POST['clearSearch'])) {
    $_SESSION['search_query'] = '';
    header('Location: ../products');
}
?>

<header class="fixed top-0 w-full py-5 flex justify-between items-center px-5 md:px-10 bg-white/85 z-10">
    <div class="w-full flex flex-col sm:flex-row sm:items-center sm:w-max gap-5 sm:gap-10">
        <div class="flex justify-between w-full">
            <div class="flex items-center gap-3">
                <i id="burger-icon" class="fa-solid fa-bars text-xl text-gray-700 sm:hidden block"></i>
                <div>
                    <a href=""><img width="100px" src="../../img/logo-decor.svg" class="p-1" alt=""></a>
                    <?php
                    if ($_SESSION['role'] == 'admin') { ?>
                        <p class="text-sm font-bold text-[#B5733A]">Admin</p>
                    <?php } ?>
                </div>
            </div>
            <div class="flex items-center gap-7 text-xl text-gray-700 sm:hidden">
                <a href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
                <img class="rounded-[100%] h-[30px]" src="../../img/default_pp.png" alt="">
            </div>
        </div>
        <div id="burger" class="sm:flex flex-col sm:flex-row sm:items-end gap-5 sm:gap-10 inactive-burger">
            <?php
            include "../../routes.php";
            foreach ($routes as $route) {
                if (gettype($route['path']) != 'string') { ?>
                    <div class="relative group">
                        <div id="categories" class="flex gap-3 items-center hover:text-[#B5733A] cursor-pointer">
                            <p>Categories</p>
                            <i class="fa-solid fa-caret-down transition-transform duration-300 group-hover:rotate-180"></i>
                        </div>
                        <div class="absolute text-sm bg-white border rounded shadow-md mt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-20">
                            <?php foreach ($route['path'] as $subroute) { ?>
                                <a href="<?= $subroute['path'] ?>" class="block px-4 py-2 hover:bg-gray-100"><?= $subroute['name'] ?></a>
                            <?php } ?>
                        </div>
                    </div>

                <?php } else { ?>
                    <a class="hover:text-[#B5733A]" href="<?= $route['path'] ?>"><?= $route['name'] ?></a>
            <?php }
            } ?>
        </div>
    </div>
    <div class="sm:flex items-center gap-7 text-xl text-gray-700 hidden">
        <?php
        if ($_SESSION['role'] != 'admin') { ?>
            <form method="post" class="relative w-full max-w-md">
                <div class="flex items-center border border-gray-300 rounded-full overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-[#B5733A] transition">
                    <i class="fa-solid fa-magnifying-glass px-4 text-gray-500"></i>
                    <input
                        type="text"
                        name="search_query"
                        value="<?= isset($_SESSION['search_query']) ? $_SESSION['search_query'] : '' ?>"
                        placeholder="Search for products..."
                        class="flex-1 py-2 pr-10 text-sm focus:outline-none">
                    <input type="submit" name="btnSearch" class="hidden">
                    <?php if (!empty($_SESSION['search_query'])): ?>
                        <button
                            type="submit"
                            name="clearSearch"
                            value="1"
                            class="px-3 text-gray-400 hover:text-black transition"
                            title="Clear search">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    <?php endif; ?>
                </div>
            </form>

        <?php } ?>
        <?php
        if (!isset($_SESSION['username'])) { ?>
            <div class="sm:flex items-center gap-3 text-xl text-gray-700 hidden">
                <button class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white hover:bg-[#9a5e2e] transition-all">Masuk</button>
                <button class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white hover:bg-[#9a5e2e] transition-all">Daftar</button>
            </div>
        <?php } else { ?>
            <?php
            if ($_SESSION['role'] != 'admin') { ?>
                <a href="../cart"><i class="fa-solid fa-cart-shopping"></i></a>
            <?php } ?>
            <div class="relative group">
                <img class="rounded-full w-[40px] cursor-pointer" src="../../img/default_pp.png" alt="">
                <div class="text-sm absolute right-0 bg-white border rounded shadow-md mt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-20">
                    <a href="" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    <a href="../logout" class="text-red-600 block px-4 py-2 hover:bg-gray-100">Logout</a>
                </div>
            </div>

        <?php } ?>
    </div>
</header>