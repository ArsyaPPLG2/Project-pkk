<?php
session_start();

// Cek jika pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses top-up setelah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $topup_amount = $_POST['topup_amount'];
    $payment_method = $_POST['payment_method'];

    // Validasi top-up amount
    if ($topup_amount <= 0) {
        $error_message = "Jumlah top-up harus lebih besar dari 0.";
    } else {
        // Proses top-up saldo
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "tokoookyu1";

        $conn = new mysqli($host, $user, $pass, $dbname);
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil saldo pengguna saat ini
       // Assume $conn is the database connection and $_SESSION['username'] is set
$username = $_SESSION['username'];
$sql = "SELECT saldo FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($current_balance);
    $stmt->fetch();
    $stmt->close();

    // Convert to integer or float to ensure it's numeric
    $current_balance = (float) $current_balance; // or (int) if you only expect whole numbers

    // Display the formatted balance
    echo "<p>Saldo Anda: RP. " . number_format($current_balance, 0, ',', '.') . "</p>";
} else {
    echo "Gagal menyiapkan statement: " . $conn->error;
}

        // Update saldo
        $new_balance = $current_balance + $topup_amount;
        $sql_update = "UPDATE user SET saldo = ? WHERE username = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("ds", $new_balance, $username);

        if ($stmt->execute()) {
            $success_message = "Top-up berhasil! Saldo baru Anda: " . number_format($new_balance, 2);
            // Arahkan kembali ke saldo.php setelah top-up berhasil
            header("Location: saldo.php");
            exit();  // Pastikan tidak ada kode yang dijalankan setelah header redirect
        } else {
            $error_message = "Terjadi kesalahan saat melakukan top-up.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        .success-message, .error-message {
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
        }

        .success-message {
            color: green;
        }

        .error-message {
            color: red;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #6c3ea4;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #5b2b91;
        }
    </style>
</head>
<body>

    <h1>Top Up Saldo</h1>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <div class="container">
        <div class="form-container">
            <form action="topup_saldo.php" method="POST">
                <label for="topup_amount">Jumlah Top Up:</label>
                <input type="number" id="topup_amount" name="topup_amount" step="0.01" min="0.01" required>

                <label for="payment_method">Metode Pembayaran:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="bank_transfer">Transfer Bank</option>
                    <option value="ewallet">E-Wallet</option>
                    <option value="credit_card">Kartu Kredit</option>
                </select>

                <button type="submit">Top Up</button>
            </form>
        </div>
    </div>

</body>
</html>
