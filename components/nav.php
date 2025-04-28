<!-- new nav -->
<header class="fixed top-0 w-full py-3 flex justify-between items-center px-5 md:px-10 bg-white/85 z-10">
    <div class="w-full flex flex-col sm:flex-row sm:items-center sm:w-max gap-5 sm:gap-10">
        <div class="flex justify-between w-full">
            <div class="flex items-center gap-3">
                <i id="burger-icon" class="fa-solid fa-bars text-xl text-gray-700 sm:hidden block"></i>
                <a href=""><img width="100px" src="<?= IMG_PATH ?>logo-decor.svg" class="p-1" alt=""></a>
            </div>
            <div class="flex items-center gap-7 text-xl text-gray-700 sm:hidden">
                <a href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
                <img class="rounded-[100%] h-[30px]" src="<?= IMG_PATH ?>default_pp.png" alt="">
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
            <?php }
                else {
                    echo '<a class="hover:text-[#B5733A]" href="' . $route['path'] . '">' . $route['name'] . '</a>';
                }
            }
            ?>
        </div>
    </div>
    <div class="sm:flex items-center gap-7 text-xl text-gray-700 hidden">
        <a href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
        <a href="/auth/signIn.html"><img class="rounded-[100%] h-[30px]" src="<?= IMG_PATH ?>default_pp.png" alt=""></a>
    </div>
</header>