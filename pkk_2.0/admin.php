<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
        }
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
        .content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background: #f4f4f4;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn.add { background: #4CAF50; }
        .btn.delete { background: red; }
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
    <div class="content">
        <h2 id="produk">Daftar Produk</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
            <!-- PHP Fetch Produk -->
            <?php
            require 'koneksi.php';
            $result = $conn->query("SELECT id_pesan, nama_produk, jumlah FROM admin_user");
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>$no</td>
                        <td>{$row['nama_produk']}</td>
                        <td>{$row['jumlah']}</td>
                        <td><a href='detail_produk.php?id={$row['id_pesan']}' class='btn'>Detail</a></td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            }
            ?>
        </table>
        <br>
        <br>
</body>
</html>