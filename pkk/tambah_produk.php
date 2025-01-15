<?php
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "ecommerce";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori_id = $_POST['kategori_id'];

    $foto_path = NULL; 
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        if (move_uploaded_file($tmp_name, $upload_dir . $foto)) {
            $foto_path = $upload_dir . $foto;
        } else {
            echo "Gagal mengunggah foto.";
            exit();
        }
    }

    $sql_products = "INSERT INTO products (product_id, nama_produk, deskripsi, harga, stok, kategori_id) 
                     VALUES ('$id_produk', '$nama_produk', '$deskripsi', '$harga', '$stok', '$kategori_id')";

    if ($conn->query($sql_products) === TRUE) {
        $sql_admin_user = "INSERT INTO admin_user ( produk, jumlah, foto) 
                           VALUES ( '$nama_produk', '$stok', '$foto_path')";

        if ($conn->query($sql_admin_user) === TRUE) {
            echo "Data berhasil ditambahkan ke tabel products dan admin_user!";
            
            header("Location: admin.php");
            exit();
        } else {
            echo "Error saat menambahkan data ke tabel admin_user: " . $conn->error;
        }
    } else {
        echo "Error saat menambahkan data ke tabel products: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 300px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        input[type="text"], input[type="number"], input[type="file"], textarea {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Produk</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="id_produk">ID Produk:</label>
            <input type="text" id="id_produk" name="id_produk" required>

            <label for="nama_produk">Nama Produk:</label>
            <input type="text" id="nama_produk" name="nama_produk" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required></textarea>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" step="0.01" required>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" required>

            <label for="kategori_id">Kategori ID:</label>
            <input type="number" id="kategori_id" name="kategori_id" required>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">

            <button type="submit" class="submit-btn">Tambah Produk</button>
        </form>
    </div>
</body>
</html>
