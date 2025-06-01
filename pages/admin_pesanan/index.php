<?php
include "../../config.php";
session_start();

$sql = "SELECT p.id, u.email, p.jenis_pengiriman, p.jenis_pembayaran, a.alamat, p.bukti_pembayaran, p.tgl_pesan, p.status, SUM(f.harga * pi.quantity) AS total_harga FROM pesanan p JOIN user u ON p.user_id = u.id JOIN user_alamat a ON p.alamat = a.id JOIN pesanan_item pi ON p.id = pi.pesanan_id JOIN furniture f ON pi.furniture_id = f.id GROUP BY p.id;";
$result = mysqli_query($conn, $sql);
if ($result) {
    $pesanan = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $pesanan = [];
    $error = mysqli_error($conn);
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


    <style>
        .activity-log {
            width: calc(100% - 40px);
            margin: 100px 20px 0 20px;
            /* top, right, bottom, left */
            background: white;
            padding: 30px;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .activity-header h2 {
            font-size: 25px;
            font-weight: 600;
            margin: 0;
            color: #333;
            color: #B5733A;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .filters input[type="text"],
        .filters select,
        .filters input[type="date"] {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 180px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #B5733A;
            font-weight: 800;
            color: white;
        }

        .bold-text {
            font-weight: bold;
        }
    </style>
</head>


<body class="font-sans">

    <?php include "../../components/nav.php"; ?>

    <div class="activity-log my-24">
        <div class="activity-header">
            <h2>Kelola Pesanan</h2>

            <div class="filters">
                <input type="text" placeholder="Search...">
                <input type="date" placeholder="dd/mm/yyyy">
                <select>
                    <option>All Modul</option>
                    <option>Kategori</option>
                    <option>User</option>
                </select>
                <select>
                    <option>All Actions</option>
                    <option>Tambah</option>
                    <option>Edit</option>
                    <option>Hapus</option>
                </select>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Email Customer</th>
                    <th>Alamat</th>
                    <th>Total Harga</th>
                    <th>Pembayaran</th>
                    <th>Pengiriman</th>
                    <th>Bukti Pembayaran</th>
                    <th>Tanggal Pesan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $data) { ?>
                    <tr>
                        <td><?= $data['email'] ?></td>
                        <td><?= $data['alamat'] ?></td>
                        <td>Rp.<?= number_format($data['total_harga'], 0, ',', '.') ?></td>
                        <td><?= $data['jenis_pembayaran'] ?></td>
                        <td><?= $data['jenis_pengiriman'] ?></td>
                        <td><a href="../../img/upload/<?= $data['bukti_pembayaran'] ?>" download class="text-blue-600 underline">Download Bukti</a></td>
                        <td><?= $data['tgl_pesan'] ?></td>
                        <td>
                            <form action="update_pesanan.php" method="POST">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <select name="status" class="border border-gray-400 rounded px-2 py-1 mb-2 w-full">
                                        <option value="Dikemas" <?= $data['status'] == 'Dikemas' ? 'selected' : '' ?>>Dikemas</option>
                                        <option value="Dikirim" <?= $data['status'] == 'Dikirim' ? 'selected' : '' ?>>Dikirim</option>
                                        <option value="Sampai" <?= $data['status'] == 'Sampai' ? 'selected' : '' ?>>Sampai</option>
                                    </select>
                                </div>
                                <input type="hidden" name="id_pesanan" value="<?= $data['id'] ?>">
                                <button type="submit" name="btnUpdate" style="background-color: #B5733A;"
                                    class="text-white font-semibold py-1 px-3 rounded w-full hover:opacity-90">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include "../../components/footer.php" ?>
</body>