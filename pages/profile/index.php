<?php
include "../../config.php";
session_start();
?>

<?php
$user_id = $_SESSION['id_user'];

$sql = "SELECT * FROM user WHERE id =$user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
} else {
  echo "User not found.";
  exit;
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Profil</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <!-- Tambahkan ini di bagian <body> -->
  <div class="container">
    <div class="left">
      <div class="profile-container">
        <img id="profilePreview" src="../../img/<?= $user['gambar'] ? "upload/".$user['gambar'] : "default_pp.png"?>" class="profile-img" />
        <h3x`>Profile Picture</h3x>
      </div>
    </div>

    <div class="right">

      <!-- Tabs -->
      <div class="tab-container">
        <button class="tab-button active" onclick="showTab('biodata')">Biodata</button>
        <button class="tab-button" onclick="showTab('alamat')">Alamat</button>
      </div>

      <!-- Biodata Section -->
      <div id="biodata" class="tab-content">
        <div class="section-title">Ubah Biodata Diri</div>
        <div class="info-row"><span style="font-weight: bold">Username</span>: <?= htmlspecialchars($user['username']) ?></div>
        <div class="info-row"><span style="font-weight: bold">Nama Lengkap</span>: <?= htmlspecialchars($user['nama_lengkap']) ?></div>
        <div class="section-title">Ubah Kontak</div>
        <div class="info-row"><span style="font-weight: bold">Email</span>: <?= htmlspecialchars($user['email']) ?></div>
        <div class="info-row"><span style="font-weight: bold">Nomor HP</span>: <?= htmlspecialchars($user['no_hp']) ?></div>
      </div>

      <!-- Alamat Section -->
      <div id="alamat" class="tab-content" style="display: none;">
        <div class="section">
          <h3 style="color: #b5733a;">Daftar Alamat</h3>
          <div class="info-row">
            <p><span style="font-weight: bold">Alamat Utama</span>: <?= htmlspecialchars($user['alamat'])?></p>
          </div>
        </div>
      </div>
      <div class="edit-button">
        <a href="../profile/edit_profile.php">Edit Profile</a>
      </div>
    </div>
  </div>

  <script>
    function showTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.style.display = 'none';
      });

      document.getElementById(tabId).style.display = 'block';

      document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
      });

      event.target.classList.add('active');
    }
  </script>
</body>

<!-- JavaScript di akhir halaman -->

</html>