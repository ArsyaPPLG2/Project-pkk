<?php
session_start(); 


if (empty($_SESSION['cart'])) {
    echo '
    <div class="empty-cart-container">
        <h2>Keranjang Anda Kosong</h2>
        <a href="home.php" class="back-button">Kembali ke Beranda</a>
    </div>';
    exit();
}

if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]); 

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .cart-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }
        .cart-item h3 {
            margin: 0;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
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
        .remove-button {
            background-color: #000; 
            text-decoration:none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h3>Keranjang Belanja Anda</h3>

        <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
            <div class="cart-item">
                <div>
                    <h3><?php echo $product['name']; ?></h3>
                    <p>Harga: Rp. <?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                    <p>Jumlah: <?php echo $product['quantity']; ?></p>
                </div>
                <div>
                    <p>Total: Rp. <?php echo number_format($product['price'] * $product['quantity'], 0, ',', '.'); ?></p>
                    <a href="cart.php?remove=<?php echo $product_id; ?>" class="remove-button">Hapus</a>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="action-buttons">
            <button onclick="window.location.href='checkout.php'">Checkout</button>
            <button onclick="window.location.href='home.php'">Kembali</button>
        </div>
    </div>
</body>
</html>
