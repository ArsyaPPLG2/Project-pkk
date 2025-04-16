<?php
session_start(); 
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "toko_db";

$conn = new mysqli($host, $user, $pass, $dbname);


if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
if (isset($_GET['id_produk']) && is_numeric($_GET['id_produk'])) {
    $id_produk = intval($_GET['id_produk']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE id_produk = ?");
       
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 1) {
        $product = $result->fetch_assoc(); 
    } else {
        echo "Produk tidak ditemukan.";
        exit();
    }

    $stmt->close();
} else {
    echo "ID produk tidak tersedia atau tidak valid.";
    exit();
}


if (!isset($_SESSION['stock'])) {
    $_SESSION['stock'] = 0; 
}


if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add' && $_SESSION['stock'] < $product['qty']) {
        $_SESSION['stock']++;
    } elseif ($_POST['action'] == 'subtract' && $_SESSION['stock'] > 0) {
        $_SESSION['stock']--;
    }
}


if (isset($_POST['add_to_cart'])) {
 
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; 
    }

    $product_id = $product['id_produk'];
    $_SESSION['cart'][$product_id] = [
        'name' => $product['nama_produk'],
        'price' => $product['harga'],
        'stock' => $product['qty']
    ];


    $_SESSION['stock'] = 0;


    header("Location: cart.php");
    exit();
}


if (isset($_POST['buy_now'])) {
   
   
    if (!isset($_SESSION['cart'])) {
   
    }

    $product_id = $product['id_produk'];
    $_SESSION['cart'][$product_id] = [
        'name' => $product['nama_produk'],
        'price' => $product['harga'],
        'stock' => $product['qty']
    ];


    header("Location: checkout.php");
    exit();
}

$stok = $product['qty'] - $_SESSION['stock']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .product-detail {
            width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .product-detail img {
            width: 100%;
            border-radius: 10px;
        }
        .product-text {
            text-align: center;
            margin: 20px 0;
        }
        .order-section, .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
        }
        .quantity-control button {
            width: 30px;
            height: 30px;
            font-size: 18px;
            background-color: #ccc;
            border: none;
            cursor: pointer;
            margin: 0 5px;
            border-radius: 5px;
        }
        .action-buttons button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .buy-now-btn {
            background-color: #4CAF50;
            color: white;
        }
        .add-to-cart-btn {
            background-color: #ffa500;
            color: white;
        }
    </style>
</head>
<body>
   
    <div class="product-detail">

        

        <h2><button onclick="history.back()">←</button>TOKOOKYU</h2>

        <div class="product-info">
            <img src="<?php echo $product['foto']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
            <div class="product-text">
                <h3><?php echo $product['nama_produk']; ?></h3>
                <p>Terjual: <?php echo $product['qty']; ?> • ⭐ 4.9 (7 rating)</p>
                <p class="price">RP. <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                <p class="description"><?php echo htmlspecialchars($product['deskripsi']); ?></p> 
            </div>
        </div>

        <form method="POST" action="">
            <div class="order-section">
                <div class="quantity-control">
                    <button name="action" value="subtract">-</button>
                    <span class="stock"><?php echo $_SESSION['stock']; ?></span>
                    <button name="action" value="add">+</button>
                </div>
                <p>Stok: <span class="stock"><?php echo $stok; ?></span></p>
                <p>Subtotal: <span class="subtotal">Rp. <?php echo number_format($product['harga'] * $_SESSION['stock'], 0, ',', '.'); ?></span></p>
            </div>

            <div class="action-buttons">
                <button type="submit" name="buy_now" class="buy-now-btn">Beli sekarang</button>
                <button type="submit" name="add_to_cart" class="add-to-cart-btn">+ Keranjang</button>
            </div>
        </form>
    </div>

<?php

$conn->close();
?>
</body>
</html>
