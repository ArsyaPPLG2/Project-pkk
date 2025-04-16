<?php
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "toko_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = isset($_GET['id_produk']) ? $_GET['id_produk'] : '';

if (!empty($id) && is_numeric($id)) {
    $sql = "DELETE FROM product WHERE id_produk = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Produk berhasil dihapus.";
        } else {
            echo "Error saat menghapus produk: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error dalam persiapan statement: " . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

$conn->close();

header("refresh:2; url=detail_produk.php");
?>
