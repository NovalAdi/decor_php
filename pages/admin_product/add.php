<?php
include "../../config.php";
session_start();

$tags = [];
$query = mysqli_query($conn, "SELECT * FROM tag");
while ($row = mysqli_fetch_assoc($query)) {
    $tags[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = str_replace(['Rp', '.', ' '], '', $_POST['harga']);
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : [];
    $gambar = $_FILES['gambar'];

    $sqls = [];

    $sql = "INSERT INTO furniture (nama, harga, deskripsi, stock, gambar_utama) VALUES ('$nama', '$harga', '$deskripsi', $stock, NULL)";
    if (mysqli_query($conn, $sql)) {
        $furniture_id = mysqli_insert_id($conn);

        foreach ($gambar['name'] as $key => $name) {
            $typeAllowed = ["image/jpeg", "image/png"];

            $gambar_utama_id = null;
            if (in_array($gambar["type"][$key], $typeAllowed)) {
                if (move_uploaded_file($gambar["tmp_name"][$key], "../../img/upload/" . basename($gambar["name"][$key]))) {

                    $sql = "INSERT INTO `furniture_gambar` (`id`, `furniture_id`, `gambar`) VALUES (NULL, $furniture_id, '$name')";
                    mysqli_query($conn, $sql);
                    $gambar_utama_id = mysqli_insert_id($conn);
                }
            }

            if ($key == 0) {
                $gambar_utama = $gambar['id'][0];
                $sql = "UPDATE `furniture` SET `gambar_utama` = $gambar_utama_id WHERE `furniture`.`id` = $furniture_id";
                $sqls[] = $sql;
                mysqli_query($conn, $sql);
            }
        }

        foreach ($tags as $tag_id) {
            mysqli_query($conn, "INSERT INTO furniture_tag (furniture_id, tag_id) VALUES ('$furniture_id', '$tag_id')");
        }

        header("Location: ../admin_product/");
    } else {
        echo "Error: " . mysqli_error($conn);
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
</head>

<body class="font-sans">

    <?php include "../../components/nav.php"; ?>

    <form method="post" enctype="multipart/form-data" class="flex flex-col px-24 my-32 gap-7">
        <h1 class="text-2xl font-semibold">Add produk</h1>
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
        <div>
            <h1 class="text-xl font-semibold mb-4">Product Name</h1>
            <input type="text" name="nama" placeholder="Enter product name"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <h1 class="text-xl font-semibold mb-4">Price</h1>
            <input type="text" id="harga" name="harga" placeholder="Enter product price"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>

        </div>

        <div>
            <h1 class="text-xl font-semibold mb-4">Description</h1>
            <textarea id="description" name="deskripsi" placeholder="Enter product description"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 h-48 resize-none leading-relaxed" required></textarea>
        </div>

        <div>
            <h1 class="text-xl font-semibold mb-4">Tags</h1>
            <div class="flex flex-wrap gap-2">
                <span id="add_tag" class="cursor-pointer border border-2 border-dashed border-[#B5733A] text-[#B5733A] px-3 py-1 rounded-full text-sm">Add Tags +</span>
            </div>
        </div>

        <div>
            <h1 class="text-xl font-semibold mb-4">Stock</h1>
            <input type="number" name="stock" placeholder="Enter product stock"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" name="btnSubmit"
                class="px-6 py-2 bg-[#B5733A] text-white rounded-lg hover:bg-[#a65c2b] transition">Add Product</button>
        </div>
    </form>

    <?php include "../../components/footer.php" ?>

    <!-- Modal -->
    <div id="tag-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Choose Tags</h2>

            <div id="tag-list" class="flex flex-wrap gap-2 mb-4 max-h-48 overflow-y-auto">
                <?php foreach ($tags as $tag): ?>
                    <span class="cursor-pointer border border-[#B5733A] text-[#B5733A] px-3 py-1 rounded-full text-sm hover:bg-[#B5733A] hover:text-white transition"
                        onclick="addTag('<?= $tag['nama'] ?>', <?= $tag['id'] ?>)">
                        <?php echo htmlspecialchars($tag['nama']); ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <div class="flex justify-end">
                <button id="cancel-tag" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Close</button>
            </div>
        </div>
    </div>

    <script>
        const hargaInput = document.getElementById("harga");

        hargaInput.addEventListener("input", function(e) {
            let value = this.value.replace(/[^0-9]/g, ''); // Hanya angka
            if (!value) {
                this.value = '';
                return;
            }

            this.value = formatRupiah(value);
        });

        function formatRupiah(angka) {
            let number_string = angka.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp ' + rupiah;
        }

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

        // Event untuk menampilkan modal tag
        document.getElementById("add_tag").addEventListener("click", () => {
            document.getElementById("tag-modal").classList.remove("hidden");
        });

        // Event untuk menampilkan modal tag
        document.getElementById("cancel-tag").addEventListener("click", () => {
            document.getElementById("tag-modal").classList.add("hidden");
        });

        function addTag(tagName, id) {
            // Cek apakah tag sudah ada
            const existing = Array.from(document.querySelectorAll(".selected-tag")).map(e => e.textContent.trim());
            if (existing.includes(tagName)) return;

            const tagWrapper = document.createElement("div");
            tagWrapper.className = "flex items-center justify-center bg-[#B5733A] text-white px-3 py-1 rounded-full text-sm cursor-pointer selected-tag";
            tagWrapper.innerText = tagName;

            // Event: klik untuk hapus tag
            tagWrapper.addEventListener("click", function() {
                tagWrapper.remove(); // hapus tag
                hiddenInput.remove(); // hapus input tersembunyi
            });

            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "tags[]";
            hiddenInput.value = id;

            const addTagBtn = document.getElementById("add_tag");
            addTagBtn.parentNode.insertBefore(tagWrapper, addTagBtn);
            addTagBtn.parentNode.appendChild(hiddenInput);
        }
    </script>

</body>

</html>