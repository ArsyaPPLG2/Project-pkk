
<?php
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "ecommerce";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    
    if (!empty($id) && is_numeric($id)) {
        
                
        $sql = "DELETE FROM products WHERE produk_id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                $message = "Produk berhasil dihapus.";
            } else {
                $message = "Error saat menghapus produk: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $message = "Error dalam persiapan statement: " . $conn->error;
        }

        header("Location: detail_produk.php");
        exit(); 
    } else {
        $message = "ID tidak valid.";
    }
}

$sql = "SELECT id_produk, name, harga, qty FROM product";
$result = $conn->query($sql);
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
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: white;
            font-size: 14px;
        }

        .btn-update {
            background-color: #4CAF50;
        }

        .btn-hapus {
            background-color: #f44336;
        }

        .btn:hover {
            opacity: 0.8;
        }
        
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 10px 15px;
            border-radius: 5px;
        }
        
        .back-btn:hover {
            background-color: #0056b3;
        }
        
        .message {
            color: green; 
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="admin.php" class="back-btn">Kembali ke Admin</a>
        <h2>Produk</h2>
        
        <?php if (isset($message)) : ?>
            <div class="message"><?php echo $message;?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>QTY</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['harga']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['qty']) . "</td>";
                            echo "<td>
                                <a href='update_produk.php?id=" . $row['id_produk'] . "' class='btn btn-update'>Update</a>
                                <a href='detail_produk.php?id=" . $row['id_produk'] . "&action=delete' class='btn btn-hapus'>Hapus</a>
                            </td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data produk</td></tr>";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
