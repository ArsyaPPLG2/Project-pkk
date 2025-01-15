<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecommerce";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $nama = $conn->real_escape_string($_POST['nama']);
    $pesan = $conn->real_escape_string($_POST['pesan']);


    $sql = "INSERT INTO pesan (nama, pesan) VALUES ('$nama', '$pesan')";

    if ($conn->query($sql) === TRUE) {
       
        header("Location: home.php");
        exit(); 
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Pesan ke Admin</title>
    <style>
       
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

h2 {
    text-align: center;
    color: #4CAF50;
    margin-top: 20px;
}

.container {
    width: 80%;
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    background-color: #f9f9f9;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    margin-top: 10px;
}

button[type="submit"]:hover {
    background-color: #45a049;
}

a {
    display: inline-block;
    margin-top: 20px;
    color: #007bff;
    text-decoration: none;
    font-size: 16px;
    text-align: center;
}

a:hover {
    color: #0056b3;
}

.notification {
    text-align: center;
    font-size: 16px;
    color: #008000;
    margin-top: 20px;
}

    </style>
</head>
<body>
    <h2>Kirim Pesan kepada Admin</h2>
    <form action="pesan_user.php" method="post">
        <label>Nama:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Pesan:</label><br>
        <textarea name="pesan" rows="5" required></textarea><br><br>

        <button type="submit">Kirim Pesan</button>
    </form>

    <br>
    <a href="home.php">Kembali ke Beranda</a>
</body>
</html>
