<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produk = $_POST['id_produk'];
    $nama_produk = $_POST['name'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['price'];
    $stok = $_POST['stock'];
    $kategori_id = $_POST['category_id'];
    $foto_path = NULL;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $upload_dir = "uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $foto_path = $upload_dir . basename($foto);
        move_uploaded_file($tmp_name, $foto_path);
    }

    $sql = "INSERT INTO products (id_produk, name, deskripsi, price, stock, category_id, foto, created_at) VALUES ('$id_produk', '$nama_produk', '$deskripsi', '$harga', '$stok', '$kategori_id', '$foto_path', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Produk berhasil ditambahkan!";
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; }
        .sidebar {
            width: 250px;
            background: #333;
            color: white;
            height: 100vh;
            padding: 20px;
            position: fixed;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background: #575757;
        }
        .container {
            margin-left: 270px;
            width: 80%;
            padding: 20px;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        input, textarea {
            width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px;
        }
        .submit-btn {
            background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; border-radius: 5px;
        }
        .submit-btn:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin.php">Daftar Produk</a>
        <a href="tambah_produk.php">Tambah Barang</a>
        <a href="pesan_dari_user.php">Pesan dari User</a>
        <a href="pesan_admin.php">Kirim Pesan</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Tambah Produk</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="id_produk">ID Produk:</label>
            <input type="text" id="id_produk" name="id_produk" required>

            <label for="nama_produk">Nama Produk:</label>
            <input type="text" id="nama_produk" name="name" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required></textarea>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="price" step="0.01" required>

            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stock" required>

            <label for="kategori_id">Kategori ID:</label>
            <input type="number" id="kategori_id" name="category_id" required>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">

            <button type="submit" class="submit-btn">Tambah Produk</button>
        </form>
    </div>
</body>
</html>
