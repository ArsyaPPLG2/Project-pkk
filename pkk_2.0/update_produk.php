<?php
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "ecommerce";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['produk_id']) && is_numeric($_GET['produk_id'])) {
    $id_produk = intval($_GET['produk_id']); 
} else {
    die("ID Produk tidak valid.");
}

$sql = "SELECT * FROM products WHERE produk_id = $id_produk";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Produk tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $produk = $_POST['produk_id'];
    $jumlah = $_POST['jumlah'];
    $kategori = $_POST['kategori']; 
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        
        $upload_dir = 'uploads/'; 
        if (move_uploaded_file($tmp_name, $upload_dir . $foto)) {
            $foto_path = $upload_dir . $foto;
        } else {
            echo "Gagal mengunggah foto.";
            exit();
        }
    } else {
        $foto_path = $product['foto'];
    }

    $sql_update = "UPDATE products SET name='$nama', deskripsi='$deskripsi', harga='$harga', qty='$jumlah', foto='$foto_path', kategori='$kategori' WHERE produk_id='$id_produk'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Data berhasil diperbarui!";
        header("Location: admin.php");
        exit();
    } else {
        echo "Error saat memperbarui data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Produk</title>
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

        input[type="text"], input[type="number"], input[type="file"], select {
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
        <h2>Update Produk</h2>
        <form action="update_produk.php?produk_id=<?= $id_produk ?>" method="POST" enctype="multipart/form-data">
            <label for="id">Id:</label>
            <input type="text" id="id" name="id" value="<?= $product['produk_id'] ?>" required readonly>

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= $product['name'] ?>" required>

            <label for="produk">Produk:</label>
            <input type="text" id="produk" name="produk" value="<?= $product['name'] ?>" required>

            <label for="jumlah">Jumlah:</label>
            <input type="number" id="jumlah" name="jumlah" value="<?= $product['qty'] ?>" required>

            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="1" <?= $product['kategori'] == 1 ? 'selected' : '' ?>>Makanan</option>
                <option value="2" <?= $product['kategori'] == 2 ? 'selected' : '' ?>>Minuman</option>
                <option value="3" <?= $product['kategori'] == 3 ? 'selected' : '' ?>>Barang Random</option>
            </select>

            <label for="deskripsi">Deskripsi:</label>
            <input type="text" id="deskripsi" name="deskripsi" value="<?= $product['deskripsi'] ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?= $product['harga'] ?>" required>

            <label for="foto">Foto:</label>
            <input type="file" name="foto" id="foto" accept="image/*">

            <button type="submit" class="submit-btn">Update Produk</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
