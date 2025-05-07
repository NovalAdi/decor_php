<?php
//impor file koneksi database
include "../../config.php";
//mulai session
session_start();

//mengambil id user dari session
$user_id = $_SESSION['id_user'];

//menyiapkan query untuk mengambil data user berdasarkan id
$sql = "SELECT * FROM user WHERE id = $user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

//memerikasa apakah ada hasil dari query
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit;
}

//mengecek jika halaman ini menerima permintaan POST dari form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //ambil data dari form
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['nomor-hp'];
    $fileFoto = $_FILES['profile_pic'];

    //tipe foto yang diizinkan
    $typeAllowed = ["image/jpeg", "image/png"];
    //menentukan folder tujuan untuk menyimpan foto
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/decor/img/upload/";

    //mengecek apakah file yang diunggah adalah tipe yang diizinkan
    if (in_array($fileFoto["type"], $typeAllowed)) {
        //memindahkan file yang diunggah ke folder tujuan
        if (move_uploaded_file($fileFoto["tmp_name"], "../../img/upload/" . basename($fileFoto["name"]))) {
            $foto = $fileFoto['name'];
        }
    }
    $sql = "UPDATE user SET username = '$username', nama_lengkap = '$nama', email = '$email', alamat = '$alamat', no_hp = $nohp, gambar = '$foto' WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: ../profile");
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/42b1412344.js" crossorigin="anonymous"></script>
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
    <style>
        :root {
            --primary-color: #b5733a;
            --background-color: #ffffff;
            --border-radius: 12px;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--background-color);
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
        }

        .profile-image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .btn {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #995d2e;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            resize: vertical;
            font-family: inherit;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
        }
    </style>
</head>

<body>

    <?php include "../../components/nav.php"; ?>

    <div class="container mt-24">
        <h2>Edit Profile</h2>

        <?php if (isset($_GET['success'])): ?>
            <p style="color: green; text-align: center;">Profil berhasil diperbarui!</p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group" style="text-align: center;">
                <img src="<?= $user['gambar'] ? '../../img/upload/' . htmlspecialchars($user['gambar']) : '../../img/default_pp.png' ?>"
                    id="preview" class="profile-image-preview">
                <input type="file" id="profilePicInput" name="profile_pic" accept="image/*">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"><?= htmlspecialchars($user['alamat']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="nomor-hp">No. HP</label>
                <input type="number" id="nomor-hp" name="nomor-hp" value="<?= htmlspecialchars($user['no_hp']) ?>">
            </div>

            <div style="text-align: center;">
                <button class="btn" type="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <?php include "../../components/footer.php" ?>

    <script>
        // Preview foto profil
        const profilePicInput = document.getElementById("profilePicInput");
        const preview = document.getElementById("preview");

        profilePicInput.addEventListener("change", function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>