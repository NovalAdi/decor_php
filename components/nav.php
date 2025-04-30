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
                if ($route['name'] == 'Categories') { ?>
                    <div class="relative drop-down">
                        <div id="categories" class="flex gap-3 items-center hover:text-[#B5733A] cursor-pointer">
                            <p>Categories</p>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <div id="categories-drop" class="inactive-drop">
                            <a href="/categories/Kitchen/" class="sm:px-3 hover:text-[#B5733A] sm:py-1.5">Kitchen</a>
                            <div class="h-[1px] bg-gray-300 max-[768px]:hidden"></div>
                            <a href="/categories/BedRoom/" class="sm:px-3 hover:text-[#B5733A] sm:py-1.5 w-max">Bed Room</a>
                            <div class="h-[1px] bg-gray-300 max-[768px]:hidden"></div>
                            <a href="/categories/LivingRoom/" class="sm:px-3 hover:text-[#B5733A] sm:py-1.5 w-max">Living Room</a>
                        </div>
                    </div>
            <?php } else {
                    echo '<a class="hover:text-[#B5733A]" href="' . $route['path'] . '">' . $route['name'] . '</a>';
                }
            }
            ?>
        </div>
    </div>
    <div class="sm:flex items-center gap-7 text-xl text-gray-700 hidden">
        <?php
        if ($_SESSION['role'] != 'admin') { ?>
            <form method="post" class="relative">
                <input type="text" name="search_query" value="<?= $_SESSION['search_query'] ?>" placeholder="Search" class="p-2 pl-10 border border-[1.5px] border-gray-400 rounded-xl text-sm w-[300px] text-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                <input type="submit" name="btnSearch" class="hidden">
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
            <a href="../signin"><img class="rounded-[100%] h-[30px]" src="../../img/default_pp.png" alt=""></a>
        <?php } ?>
    </div>
</header>