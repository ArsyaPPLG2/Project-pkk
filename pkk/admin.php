<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ecommerce";


$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); 
    $stmt = $conn->prepare("DELETE FROM pesan_user WHERE id_pesan = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Pesan berhasil dihapus'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pesan: " . $conn->error . "'); window.location.href='admin.php';</script>";
    }
    $stmt->close();
}

$sql = "SELECT `id_admin`, `id_user`, `id_pesan`, `produk`, `jumlah`, `foto` FROM `admin_user`";
$result = $conn->query($sql);

$sql_pesan = "SELECT id_pesan, nama, pesan, tanggal FROM pesan_user";
$result_pesan = $conn->query($sql_pesan);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            text-align: center;
        }

        .add-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            margin: 20px 0;
        }

        .add-btn:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .detail-btn, .delete-btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
        }

        .detail-btn {
            background-color: #4CAF50;
        }

        .detail-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: red;
        }

        .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat datang di Halaman Admin</h2>

        <h3>Daftar Produk</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no . "</td>";
                        echo "<td>" . htmlspecialchars($row['produk']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                        echo "<td><a href='detail_produk.php?id=" . $row['id_pesan'] . "' class='detail-btn'>Detail</a></td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data produk</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Pesan dari User</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_pesan && $result_pesan->num_rows > 0) {
                    $no = 1;
                    while ($row = $result_pesan->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['pesan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                        echo "<td><a href='admin.php?delete_id=" . $row['id_pesan'] . "' class='delete-btn' onclick='return confirm(\"Yakin ingin menghapus pesan ini?\")'>Hapus</a></td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada pesan dari user</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="pesan_admin.php" class="add-btn">Kirim Notifikasi kepada Pengguna</a>
        <a href="tambah_produk.php" class="add-btn">Tambah Barang</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
