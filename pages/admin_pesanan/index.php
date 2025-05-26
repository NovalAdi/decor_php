<?php
include "../../config.php"; //untuk mengimpor file konfigurasi yang berisi koneksi ke database ($conn)
session_start(); //menyimpan data login user serta mengakses variabel global

$sql = "";

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

    <?php include "../../components/nav.php"; //untuk tampilan navbar agar konsisten di halaman admin ?>


    <div class="activity-log">
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
                    <th>Username</th>
                    <th>Email Address</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Pengiriman</th>
                    <th>Catatan</th>
                    <th>Bukti Pembayaran</th>
                    <th>Waktu Pembayaran</th>
                    <th>Status</th>
                    <th>Ubah status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>username1</td>
                    <td>abccompany@gmail.com</td>
                    <td>Rp 50.000</td>
                    <td>Cash On Delivery</td>
                    <td>Pick Up</td>
                    <td>Percepat pengiriman</td>
                    <td><a href="#" class="text-blue-600 underline">lihat bukti</a></td>
                    <td>2025-05-25</td>
                    <td><span class="text-yellow-600 font-semibold">Pending</span></td>
                    <td>
                        <form action="ubah_status.php" method="POST">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <select name="status" class="border border-gray-400 rounded px-2 py-1 mb-2 w-full">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <input type="hidden" name="order_id" value="123"> <!-- Ganti dengan ID pesanan -->
                            <button type="submit" style="background-color: #B5733A;"
                                class="text-white font-semibold py-1 px-3 rounded w-full hover:opacity-90">
                                Update
                            </button>

                        </form>
                    </td>
                </tr>
                <tr>
                    <td>username1</td>
                    <td>abccompany@gmail.com</td>
                    <td>Rp 50.000</td>
                    <td>Cash On Delivery</td>
                    <td>Pick Up</td>
                    <td>Percepat pengiriman</td>
                    <td><a href="#" class="text-blue-600 underline">lihat bukti</a></td>
                    <td>2025-05-25</td>
                    <td><span class="text-yellow-600 font-semibold">Pending</span></td>
                    <td>
                        <form action="ubah_status.php" method="POST">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <select name="status" class="border border-gray-400 rounded px-2 py-1 mb-2 w-full">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <input type="hidden" name="order_id" value="123"> <!-- Ganti dengan ID pesanan -->
                            <button type="submit" style="background-color: #B5733A;"
                                class="text-white font-semibold py-1 px-3 rounded w-full hover:opacity-90">
                                Update
                            </button>

                        </form>
                    </td>
                </tr>

                <tr>
                    <td>username1</td>
                    <td>abccompany@gmail.com</td>
                    <td>Rp 50.000</td>
                    <td>Cash On Delivery</td>
                    <td>Pick Up</td>
                    <td>Percepat pengiriman</td>
                    <td><a href="#" class="text-blue-600 underline">lihat bukti</a></td>
                    <td>2025-05-25</td>
                    <td><span class="text-yellow-600 font-semibold">Pending</span></td>
                    <td>
                        <form action="ubah_status.php" method="POST">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <select name="status" class="border border-gray-400 rounded px-2 py-1 mb-2 w-full">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <input type="hidden" name="order_id" value="123"> <!-- Ganti dengan ID pesanan -->
                            <button type="submit" style="background-color: #B5733A;"
                                class="text-white font-semibold py-1 px-3 rounded w-full hover:opacity-90">
                                Update
                            </button>

                        </form>
                    </td>
                </tr>

                <tr>
                    <td>username1</td>
                    <td>abccompany@gmail.com</td>
                    <td>Rp 50.000</td>
                    <td>Cash On Delivery</td>
                    <td>Pick Up</td>
                    <td>Percepat pengiriman</td>
                    <td><a href="#" class="text-blue-600 underline">lihat bukti</a></td>
                    <td>2025-05-25</td>
                    <td><span class="text-yellow-600 font-semibold">Pending</span></td>
                    <td>
                        <form action="ubah_status.php" method="POST">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <select name="status" class="border border-gray-400 rounded px-2 py-1 mb-2 w-full">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <input type="hidden" name="order_id" value="123"> <!-- Ganti dengan ID pesanan -->
                            <button type="submit" style="background-color: #B5733A;"
                                class="text-white font-semibold py-1 px-3 rounded w-full hover:opacity-90">
                                Update
                            </button>

                        </form>
                    </td>
                </tr>

                <tr>
                    <td>username1</td>
                    <td>abccompany@gmail.com</td>
                    <td>Rp 50.000</td>
                    <td>Cash On Delivery</td>
                    <td>Pick Up</td>
                    <td>Percepat pengiriman</td>
                    <td><a href="#" class="text-blue-600 underline">lihat bukti</a></td>
                    <td>2025-05-25</td>
                    <td><span class="text-yellow-600 font-semibold">Pending</span></td>
                    <td>
                        <form action="ubah_status.php" method="POST">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <select name="status" class="border border-gray-400 rounded px-2 py-1 mb-2 w-full">
                                    <option value="Pending" selected>Pending</option>
                                    <option value="Diproses">Diproses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            <input type="hidden" name="order_id" value="123"> <!-- Ganti dengan ID pesanan -->
                            <button type="submit" style="background-color: #B5733A;"
                                class="text-white font-semibold py-1 px-3 rounded w-full hover:opacity-90">
                                Update
                            </button>

                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>