<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

$sqlProduk = "SELECT f.id f_id, pi.id pi_id, f.nama, fg.gambar, f.harga FROM pesanan_item pi JOIN furniture f ON f.id = pi.furniture_id JOIN furniture_gambar fg ON f.gambar_utama = fg.id WHERE pi.id = $id;";
$resultProduk = mysqli_query($conn, $sqlProduk);
if ($resultProduk) {
    $produk = mysqli_fetch_assoc($resultProduk);
} else {
    echo "Error: " . mysqli_error($conn);
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

<body>
    <form class="flex flex-col gap-5 mx-20 my-24" method="post" action="create_review.php?id=<?= $id ?>" enctype="multipart/form-data">
        <div class="flex gap-2 items-center">
            <img class="w-[80px] h-[80px]" src="../../img/upload/<?= $produk['gambar'] ?>" alt="">
            <input type="hidden" name="id_produk" value="<?= $produk['f_id'] ?>">
            <div>
                <h1 class="font-medium"><?= $produk['nama'] ?></h1>
                <p><?= $produk['harga'] ?></p>
            </div>
        </div>
        <div class="flex gap-2 items-center">
            <img src="../../img/star.png" class="w-[20px] h-[20px]" alt="">
            <input type="text" name="rating" class="w-[100px] h-[30px] border border-gray-400 rounded-lg p-2" placeholder="5.0" required>
        </div>

        <div class="flex flex-col gap-2">
            <h1 class="text-xl font-medium">Review</h1>
            <textarea name="ulasan" class="w-full h-[100px] border border-gray-400 rounded-lg p-2" placeholder="Your review" required></textarea>
        </div>
        <div>
            <h1 class="text-xl font-semibold mb-4">Image</h1>
            <div class="flex items-center gap-4">
                <label id="drop-zone"
                    class="w-48 h-48 p-5 flex flex-col items-center justify-center border-2 border-dashed border-gray-500 rounded-lg text-center text-gray-500 transition duration-300 ease-in-out hover:border-blue-500 hover:text-blue-500">
                    <p class="text-lg font-semibold">Drop files here</p>
                    <input type="file" id="file-input" name="gambar[]" class="hidden" multiple />
                    <p class="text-sm mt-2">or click to upload</p>
                </label>
                <div id="preview" class="flex flex-wrap justify-center gap-4"></div>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" name="btnSubmit" class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white hover:bg-[#9a5e2e] transition-all">Post</button>
        </div>
    </form>

    <script>
        const dropZone = document.getElementById("drop-zone");
        const fileInput = document.getElementById("file-input");
        const previewContainer = document.getElementById("preview");

        let allFiles = [];

        // Prevent default behavior
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => e.preventDefault());
        });

        dropZone.addEventListener("dragover", () => {
            dropZone.classList.add("bg-gray-200");
        });

        dropZone.addEventListener("dragleave", () => {
            dropZone.classList.remove("bg-gray-200");
        });

        dropZone.addEventListener("drop", (e) => {
            dropZone.classList.remove("bg-gray-200");
            const files = Array.from(e.dataTransfer.files);
            if (files.length) {
                addFiles(files);
            }
        });

        fileInput.addEventListener("change", () => {
            addFiles(Array.from(fileInput.files));
        });

        function addFiles(files) {
            files.forEach(file => {
                if (!file.type.startsWith("image/")) return;

                // Hindari duplikat berdasarkan nama file
                if (!allFiles.some(f => f.name === file.name && f.size === file.size)) {
                    allFiles.push(file);

                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement("img");
                        img.src = e.target.result;
                        img.className = "w-48 h-48 object-cover rounded shadow";
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Update file input secara manual (tidak wajib, hanya untuk validasi jika kamu kirim file)
            const dataTransfer = new DataTransfer();
            allFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;
        }
    </script>
</body>

</html>