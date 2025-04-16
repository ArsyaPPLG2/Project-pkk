<?php
session_start(); 


if (empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.'); window.location.href='home.php';</script>";
    exit();
}

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "toko_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$name = $_SESSION['name'];
$sql = "SELECT saldo FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$stmt->bind_result($saldo);
$stmt->fetch();
$stmt->close();

$total_price = 0;
foreach ($_SESSION['cart'] as $product) {
    $total_price += $product['price'] * $product['stock'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($saldo >= $total_price) {

        $new_balance = $saldo - $total_price;
        $sql = "UPDATE users SET saldo = ? WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ds", $new_balance, $name);
        $stmt->execute();
        $stmt->close();

        if (!isset($_SESSION['purchase_history'])) {
            $_SESSION['purchase_history'] = []; 
        }

        foreach ($_SESSION['cart'] as $product) {
            $_SESSION['purchase_history'][] = [
                'name_produk' => $product['nama_produk'],
                'price' => $product['price'],
                'stock' => $product['stock']
            ];
        }

        unset($_SESSION['cart']);

        echo "<script>alert('Pembayaran berhasil! Terima kasih telah berbelanja.'); window.location.href='home.php';</script>";
        exit();
    } else {
    
        echo "<script>alert('Saldo Anda tidak cukup untuk menyelesaikan pembelian.'); window.location.href='home.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .checkout-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .checkout-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .checkout-item h3 {
            margin: 0;
        }
        .action-buttons {
            display: flex; 
            gap: 10px; 
            margin-top: 20px;
        }
        .action-buttons button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }
        .action-buttons button:last-child {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>

        <?php foreach ($_SESSION['cart'] as $product): ?>
            <div class="checkout-item">
                <div>
                    <h3><?php echo $product['name_produk']; ?></h3>
                    <p>Harga: Rp. <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                    <p>Jumlah: <?php echo $product['stock']; ?></p>
                </div>
                <div>
                    <p>Total: Rp. <?php echo number_format($product['price'] * $product['stock'], 0, ',', '.'); ?></p>
                </div>
            </div>
        <?php endforeach; ?>

        <p><strong>Total Pembayaran: Rp. <?php echo number_format($total_price, 0, ',', '.'); ?></strong></p>

        <form method="POST" action="">
            <div class="action-buttons">
                <button type="submit">Selesaikan Pembayaran</button>
                <button onclick="window.location.href='cart.php'" type="button">Kembali ke Keranjang</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
