<?php
session_start(); 

if (empty($_SESSION['purchase_history'])) {
    echo "<h2>Riwayat Pembelian Anda Kosong</h2>";
    echo '<a href="home.php">Kembali ke Beranda</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pembelian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .history-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .history-item {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .history-item:last-child {
            border-bottom: none; 
        }
        .action-buttons {
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
    </style>
</head>
<body>
    <div class="history-container">
        <h2>Riwayat Pembelian Anda</h2>

        <?php foreach ($_SESSION['purchase_history'] as $purchase): ?>
            <div class="history-item">
                <h3><?php echo htmlspecialchars($purchase['name']); ?></h3>
                <p>Harga: Rp. <?php echo number_format($purchase['price'], 0, ',', '.'); ?></p>
                <p>Jumlah: <?php echo $purchase['quantity']; ?></p>
                <p>Total: Rp. <?php echo number_format($purchase['price'] * $purchase['quantity'], 0, ',', '.'); ?></p>
            </div>
        <?php endforeach; ?>

        <div class="action-buttons">
            <button onclick="window.location.href='home.php'">Kembali ke Beranda</button>
        </div>
    </div>
</body>
</html>
