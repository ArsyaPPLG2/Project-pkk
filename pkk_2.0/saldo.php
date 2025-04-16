<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecommerce";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$sql = "SELECT saldo FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($saldo);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saldo Anda</title>
    <style>
                a {
            color: black;
            text-decoration: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background: linear-gradient(135deg, #6c3ea4, #b76bb3);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .saldo-container {
            padding: 20px;
            text-align: center;
        }

        .saldo-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .saldo-container .saldo {
            font-size: 30px;
            font-weight: bold;
            color: #6c3ea4;
        }

        .login-message {
            font-size: 18px;
            color: #b76bb3;
            margin-top: 20px;
        }

        .btn {
            background-color: #6c3ea4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #5b2b91;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .saldo-box {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .saldo-box p {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="profile">
        <?php if (isset($_SESSION['username'])): ?>
            <a href="profil.php" style="color: white;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
        <?php else: ?>
            <a href="login.php" style="color: white; text-decoration: none; font-weight: bold;">LOGIN</a>
        <?php endif; ?>
    </div>
    <h2><a href="home.php">TOKOOKYU</a></h2>
</div>

<div class="container">
    <div class="saldo-box">
        <?php if (isset($_SESSION['username'])): ?>
            <h2>Saldo Anda</h2>
            <p class="saldo">
                RP. 
                <?php
                   echo isset($saldo) && is_numeric($saldo) ? number_format($saldo, 0, '.', ',') : "0";
                ?>
            </p>
            <form action="topup_saldo.php" method="get">
                <button type="submit" class="btn">Top Up Saldo</button>
            </form>
        <?php else: ?>
            <h2>Silakan login untuk melihat saldo Anda</h2>
            <p class="login-message">Anda harus login terlebih dahulu untuk mengakses informasi saldo.</p>
            <a href="login.php" class="btn">Login</a>
        <?php endif; ?>
    </div>
</div>

</div>

</body>
</html>

<?php

$conn->close();
?>
