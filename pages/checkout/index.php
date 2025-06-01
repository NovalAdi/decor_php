<?php
include "../../config.php";
session_start();

if (!isset($_SESSION['checkout'])) {
    header("Location: ../home");
}

$resultAlamat = mysqli_query($conn, "SELECT id, nama, alamat FROM user_alamat WHERE user_id = " . $_SESSION['id_user']);
$dataAlamat = mysqli_fetch_all($resultAlamat, MYSQLI_ASSOC);

$sql = "SELECT c.id, f.nama, GROUP_CONCAT(DISTINCT g.gambar SEPARATOR ', ') as gambar, f.harga, c.quantity, f.id FROM cart c JOIN furniture f ON c.furniture_id = f.id JOIN user u ON c.user_id = u.id join furniture_gambar g on f.gambar_utama = g.id WHERE u.id = " . $_SESSION['id_user'] . " AND c.id IN(" . implode(',', $_SESSION['checkout']) . ") GROUP BY f.nama, f.harga";

$result = mysqli_query($conn, $sql);

if ($result) {
    $dataP = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

$hargaTotal = 0;
$totalItem = 0;
foreach ($dataP as $key => $value) {
    $hargaTotal += $value['harga'] * $value['quantity'];
    $totalItem += $value['quantity'];
}

if (isset($_POST['btnCheckout'])) {
    $products = $dataP;
    $products = array_map(function ($item) {
        return $item['id'];
    }, $products);
    $shipping = $_POST['shipping'];
    $payment = $_POST['payment'];
    $alamat = $_POST['alamat'];
    $fileFoto = $_FILES['foto'];

    $typeAllowed = ["image/jpeg", "image/png"];

    if (in_array($fileFoto["type"], $typeAllowed)) {
        if (move_uploaded_file($fileFoto["tmp_name"], "../../img/upload/" . basename($fileFoto["name"]))) {
            $foto = $fileFoto['name'];
        }
    }

    $sql = "INSERT INTO `pesanan` (`id`, `user_id`, `alamat`, `status`, `bukti_pembayaran`, `jenis_pengiriman`, `jenis_pembayaran`, `tgl_pesan`) VALUES (NULL, " . $_SESSION['id_user'] . ", $alamat, 'Dikemas', '$foto', '$shipping', '$payment', current_timestamp());";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $id_pesanan = mysqli_insert_id($conn);

        foreach ($dataP as $key => $value) {
            $sqlItem = "INSERT INTO `pesanan_item` (`id`, `pesanan_id`, `furniture_id`, `quantity`) VALUES (NULL, $id_pesanan, " . $value['id'] . ", " . $value['quantity'] . ");";
            $result = mysqli_query($conn, $sqlItem);
        }

        if ($result) {
            $sqlDelete = "DELETE FROM cart WHERE id IN (" . implode(',', $_SESSION['checkout']) . ")";
            $resultDelete = mysqli_query($conn, $sqlDelete);

            foreach ($dataP as $item) {
                $updateStockSql = "UPDATE furniture SET stock = stock - " . intval($item['quantity']) . " WHERE id = " . intval($item['id']);
                mysqli_query($conn, $updateStockSql);
            }
            
            if ($resultDelete) {
                unset($_SESSION['checkout']);
                header("Location: ../home");
            } else {
                echo "Error deleting items from cart.";
            }
        } else {
            echo "Error inserting order items.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="payment.css">
    <link rel="stylesheet" href="/home/style.css">
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
</head>

<body class="font-sans">

    <?php include "../../components/nav.php"; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="container mb-16 mt-24">
            <div class="left-section">
                <div class="payment-method">
                    <div class="section-title">Shipping Address <?= var_dump($sqlItem) ?></div>
                    <select name="alamat" class="w-full border border-gray-300 rounded px-2 py-2">
                        <?php foreach ($dataAlamat as $key => $value) { ?>
                            <option value="<?= $value['id'] ?>">
                                <?= $value['nama'] ?> - <?= $value['alamat'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="section mt-5">
                    <div class="store">
                        <div class="store-title">Decor Official Store</div>
                        <div>
                            <?php foreach ($dataP as $key => $data) { ?>
                                <div class="product">
                                    <img src="../../img/upload/<?= $data['gambar'] ?>">
                                    <div class="product-details">
                                        <p><?= $data['nama'] ?></p>
                                        <span class="price"><?= $data['quantity'] ?> x Rp<?= number_format($data['harga'], 0, ',', '.') ?> = <?= number_format($data['quantity'] * $data['harga'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <hr class="line">
                        <div class="store-title">Shipping</div>
                        <div class="shipping">
                            <label class="flex gap-3">
                                <input type="radio" name="shipping" value="cargo" required>
                                <div>
                                    <p>Cargo</p>
                                    <p>Estimate Arrived 25-27 Jan</p>
                                </div>
                            </label>
                        </div>
                        <div class="shipping">
                            <label class="flex gap-3">
                                <input type="radio" name="shipping" value="economi">
                                <div>
                                    <p>Economi</p>
                                    <p>Estimate Arrived 7 - 11 Jan</p>
                                </div>
                            </label>
                        </div>
                        <div class="shipping">
                            <label class="flex gap-3">
                                <input type="radio" name="shipping" value="instan">
                                <div>
                                    <p>Instan (Arrived at the same day)</p>
                                    <p>Arrived Today</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="right-section">
                <div class="section">
                    <div class="payment-method">
                        <div class="section-title">
                            <p>Payment Method</p>
                        </div>
                        <label>
                            <input type="radio" name="payment" value="bca" required>
                            <img src="https://images.tokopedia.net/img/payment/icons/bca.png" alt="BCA">
                            <h1>BCA Virtual Account</h1>
                        </label>
                        <hr class="line">
                        <label>
                            <input type="radio" name="payment" value="gopay">
                            <img src="https://images.tokopedia.net/img/payment/icons/gopay.png" alt="Gopay">
                            <h1>Gopay</h1>
                        </label>
                        <hr class="line">
                        <label>
                            <input type="radio" name="payment" value="cod">
                            <h1>COD (Cash On Delivery)</h1>
                        </label>
                        <hr class="line">
                    </div>
                </div>

                <div class="section">
                    <div class="summary">
                        <div class="summary-item">
                            <span>Total Price (<?= $totalItem ?> Item)</span>
                            <span>Rp<?= number_format($hargaTotal, 0, ',', '.') ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Total Shipping Cost</span>
                            <span>Rp50.000</span>
                        </div>
                        <div class="summary-item">
                            <span>Total Shipping Insurance</span>
                            <span>Rp50.000</span>
                        </div>
                        <div class="summary-item summary-total">
                            <span>Total Amount Due</span>
                            <span>Rp2.100.000</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 mb-3">
                    <p>Kirim bukti pembayaran</p>
                    <input type="file" name="foto" required class="border border-gray-300 rounded px-2 py-2">
                </div>

                <input type="submit" class="mt-3 w-full text-white py-2 rounded-lg bg-[#B5733A]" value="Checkout" name="btnCheckout">
            </div>
        </div>
    </form>

    <?php include "../../components/footer.php" ?>
</body>

</html>