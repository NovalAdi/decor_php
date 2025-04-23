<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decor Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-[100vh] w-[100vw] bg-[#F0E7E1]">
    <section class="flex justify-evenly items-center h-full">
        <form action="/home" class="w-[30vw] flex flex-col gap-10">
            <img src="logo-decor[1].svg" alt="" width="200px">
            <div>
                <div class="flex flex-col gap-2">
                    <label>Username</label>
                    <input type="text" placeholder="Username"
                        class="p-2 border border-[1.5px] border-gray-400 rounded-lg ">
                </div>
                <div class="flex flex-col mt-4 gap-2">
                    <label>Password</label>
                    <div class="flex flex-col relative ">
                        <input id="input" type="password" placeholder="Password"
                            class="p-2 border border-[1.5px] border-gray-400 rounded-lg">
                        <a id="eye" class="h-full absolute right-3 flex items-center"><img id="eye-img" src="hide.png"
                                alt="" width="25px"></a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <a href="" class="text-gray-600">Forget Password?</a>
                <button type="submit" class="w-full text-white py-2 rounded-lg bg-[#B5733A]">Sign in</button>
                <p class="self-center">or <a href="signUp.html" class="text-[#B5733A]">Sign up</a></p>
            </div>
        </form>
        <img src="" alt="" width="430">
    </section>

    <script src="script.js"></script>
</body>

</html>