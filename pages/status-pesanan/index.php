<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
        <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="tabs">
        <button class="tab-btn active" onclick="showTab('diproses')">Sedang Diproses</button>
        <button class="tab-btn" onclick="showTab('dikirim')">Sedang Dikirim</button>
        <button class="tab-btn" onclick="showTab('selesai')">Selesai</button>
      </div>
      
      <div class="tab-content active" id="diproses">
        <!-- Kartu Pesanan Diproses -->
        <div class="order-card">
          <img src="gambar-produk/kursi.jpg" alt="Kursi Kayu" class="product-img">
          <div class="order-info">
            <strong>Kursi Kayu Minimalis</strong>
            <p>Tanggal Pesan: 1 Mei 2025<br>Estimasi Selesai: 3 Mei 2025</p>
            <div class="actions">
                <a href="#">Detail Transaksi</a>
                <button class="btn">Batalkan Pesanan</button>
            </div>
            <span class="status">Sedang Diproses</span>
          </div>
        </div>
      </div>
      
      <div class="tab-content" id="dikirim">
        <!-- Kartu Pesanan Dikirim -->
        <div class="order-card">
            <img src="gambar-produk/kursi.jpg" alt="Kursi Kayu" class="product-img">
            <div class="order-info">
                <strong>Meja Belajar Anak</strong>
                <p>Dikirim pada: 29 April 2025<br>Kurir: JNE - REG</p>
                    <div class="actions">
                        <a href="#">Detail Transaksi</a>
                        <button class="btn">Lacak Pengiriman</button>
                    </div>
                <span class="status">Sedang Dikirim</span>
            </div>
        </div>
      </div>
      
      <div class="tab-content" id="selesai">
        <!-- Kartu Pesanan Selesai -->
        <div class="order-card">
            <img src="gambar-produk/kursi.jpg" alt="Kursi Kayu" class="product-img">
            <div class="order-info">
                <strong>Lemari Pakaian 2 Pintu</strong>
                <p>Diterima pada: 27 April 2025<br>Terima kasih atas pembeliannya!</p>
                <button class="btn">Beri Ulasan</button>
                <span class="status">Selesai</span>
            </div>
        </div>
      </div>
      <script src="script.js"></script>
</body>
</html>