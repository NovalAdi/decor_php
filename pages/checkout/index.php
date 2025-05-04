<?php
include "../../config.php";
session_start();

$sql = "SELECT c.id, p.nama, p.gambar, p.harga, c.quantity, c.id_pesanan FROM cart c JOIN produk p ON c.id_produk = p.id JOIN user u ON c.id_user = u.id WHERE u.id = " . $_SESSION['id_user'] . " AND c.id IN(" . implode(',', $_SESSION['checkout']) . ")";

$result = mysqli_query($conn, $sql);
$foto;

if ($result) {
    $_SESSION['data_checkout'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if (isset($_POST['btnCheckout']) && $_SESSION['checkout']) {
    $products = $_SESSION['checkout'];
    $fileFoto = $_FILES['foto'];

    $typeAllowed = ["image/jpeg", "image/png"];

    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/decor/img/upload/";

    if (in_array($fileFoto["type"], $typeAllowed)) {
        if (move_uploaded_file($fileFoto["tmp_name"], "../../img/upload/" . basename($fileFoto["name"]))) {
            $foto = $fileFoto['name'];
        }
    }

    $sql = "INSERT INTO `pesanan` (`id`, `id_user`, `status`, `bukti_pembayaran`, `created_at`, `updated_at`) VALUES (NULL, " . $_SESSION['id_user'] . ", 'Dikemas', '$foto', current_timestamp(), current_timestamp());";

    $result = mysqli_query($conn, $sql);
    if ($result) {
        $id_pesanan = mysqli_insert_id($conn);

        foreach ($products as $key => $value) {
            $sqlUpdate = "UPDATE `cart` SET `id_pesanan` = '$id_pesanan' WHERE `cart`.`id` = $value";
            $result = mysqli_query($conn, $sqlUpdate);
        }
    }
    unset($_POST);
    header("Location: ../home");
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
                <div class="section">
                    <div class="section-title">Shipping Address</div>
                    <div class="address">
                        <div class="details">
                            <p> House • John Doe</p><br>
                            <p>John Doe, 123 Maple Street, Apt. 4B, Seattle, WA 98101, United Statest</p>
                            <p>6285872042022</p>
                        </div>
                        <button class="btn-ganti">Change</button>
                    </div>
                </div>

                <div class="section">
                    <div class="store">
                        <div class="store-title">Decor Official Store</div>
                        <div>
                            <?php foreach ($_SESSION['data_checkout'] as $key => $data) { ?>
                                <div class="product">
                                    <img src="../../img/upload/<?= $data['gambar'] ?>">
                                    <div class="product-details">
                                        <p><?= $data['nama'] ?></p>
                                        <span class="price"><?= $data['quantity'] ?> x Rp<?= number_format($data['harga'], 0, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <hr class="line">
                        <div class="shipping">
                            <label class="flex gap-3">
                                <input type="radio" name="shipping" checked>
                                <div>
                                    <p>Cargo</p>
                                    <p>Estimate Arrived 25-27 Jan</p>
                                </div>
                            </label>
                        </div>
                        <div class="shipping">
                            <label class="flex gap-3">
                                <input type="radio" name="shipping" checked>
                                <div>
                                    <p>Economi</p>
                                    <p>Estimate Arrived 7 - 11 Jan</p>
                                </div>
                            </label>
                        </div>
                        <div class="shipping">
                            <label class="flex gap-3">
                                <input type="radio" name="shipping" checked>
                                <div>
                                    <p>Instan (Arrived at the same day)</p>
                                    <p>Arrived Today</p>
                                </div>
                            </label>
                        </div>

                        <hr class="line">
                        <br>
                        <div class="insurance">
                            <label><input type="checkbox" name="insurance"> Use Shipping Ansurance (Rp50.000)</label>
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
                            <input type="radio" name="payment" checked>
                            <img src="https://images.tokopedia.net/img/payment/icons/bca.png" alt="BCA">
                            <h1>BCA Virtual Account</h1>
                        </label>
                        <hr class="line">
                        <label>
                            <input type="radio" name="payment" checked>
                            <img src="https://images.tokopedia.net/img/payment/icons/gopay.png" alt="Gopay">
                            <h1>Gopay</h1>
                        </label>
                        <hr class="line">
                        <label>
                            <input type="radio" name="payment">
                            <h1>COD (Cash On Delivery)</h1>
                        </label>
                        <hr class="line">
                    </div>
                </div>

                <div class="section">
                    <div class="summary">
                        <div class="summary-item">
                            <span>Total Price (1 Item)</span>
                            <span>Rp2.000.000</span>
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
                    <input type="file" name="foto">
                </div>

                <input type="submit" class="mt-3 w-full text-white py-2 rounded-lg bg-[#B5733A]" value="Checkout" name="btnCheckout">
            </div>
        </div>
    </form>

    <?php include "../../components/footer.php" ?>
</body>

</html>