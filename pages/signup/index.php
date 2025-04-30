<?php
include "../../config.php";

if (isset($_POST['btnSubmit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $phash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES (NULL, '$username', '$email', '$phash');";
    
    $query = mysqli_query($conn, $sql);

    if ($query) {
        header("Location: ../signin/");
    } else {
        echo "Registration failed!";
    }
    mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decor Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class=" h-[100vh] w-[100vw] bg-[#F0E7E1]">
    <div class="flex justify-evenly items-center h-full">
        <form method="post" class="w-[30vw] flex flex-col gap-10"> 
            <img src="../../img/logo-decor.svg" alt="" width="200px">
            <div>
                <div class="flex flex-col gap-2">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Username"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-lg">
                </div>
                <div class="flex flex-col mt-4 gap-2">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="email@gmail.com"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-lg">
                </div>
                <div class="flex flex-col mt-4 gap-2">
                    <label>Password</label>
                    <div class="flex flex-col relative ">
                        <input id="input" name="password" type="password" placeholder="Password"
                            class="p-2 border border-[1.5px] border-gray-400 rounded-lg">
                        <a id="eye" class="h-full absolute right-3 flex items-center"><img id="eye-img" src="../../img/hide.png"
                                alt="" width="25px"></a>

                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <a href="" class="text-gray-600">Forget Password?</a>
                <input name="btnSubmit" type="submit" class="w-full text-white py-2 rounded-lg bg-[#B5733A]" value="Sign Up">
                <p class="self-center">Already have an account ? <a href="../signin" class="text-[#B5733A]">Sign In</a></p>
            </div>
        </form>
        <img src="../../img/Group_15.svg" alt="" width="430px">
    </div>

    <script src="script.js"></script>
</body>

</html>