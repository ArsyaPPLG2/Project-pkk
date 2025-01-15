<?php
session_start();
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "ecommerce";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_POST['submit_help'])) {
    $user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; 
    $user_message = $conn->real_escape_string($_POST['message']); 

    $sql = "INSERT INTO pesan (nama, pesan, tanggal) VALUES ('$user_name', '$user_message', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: home.php");
        exit(); 
    } else {
        $error_message = "Gagal mengirim permintaan bantuan: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Bantuan</title>
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
        .help-container {
            width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="help-container">
        <button onclick="history.back('home.php')">←</button>
        <h2>Butuh Bantuan?</h2>

        <?php
        if (isset($error_message)) {
            echo "<p class='message' style='color: red;'>$error_message</p>";
        }
        ?>

        <form method="POST" action="help.php">
            <label for="message">Pesan Anda:</label>
            <textarea name="message" id="message" placeholder="Jelaskan masalah Anda..."></textarea>
            <button type="submit" name="submit_help">Kirim Permintaan</button>
        </form>
    </div>
</body>
</html>
