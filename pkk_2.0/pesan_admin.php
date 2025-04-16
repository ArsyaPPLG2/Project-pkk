<?php
session_start();
require 'koneksi.php';

// Proses Kirim Pesan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO pesan_admin (user_id, status, message, sent_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_id, $status, $message);

    if ($stmt->execute()) {
        echo "<script>alert('Notifikasi berhasil dikirim!'); window.location.href = 'pesan_admin.php';</script>";
    } else {
        echo "<script>alert('Gagal mengirim notifikasi.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Notifikasi | Admin Panel</title>
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
        .sidebar h2 { text-align: center; margin-bottom: 20px; }
        .sidebar a {
            display: block; color: white; text-decoration: none;
            padding: 10px; margin: 5px 0; border-radius: 5px;
        }
        .sidebar a:hover { background: #575757; }
        .content {
            margin-left: 270px;
            padding: 20px;
            width: calc(100% - 270px);
        }
        .form-container {
            width: 60%;
            margin: 20px auto;
            text-align: center;
        }
        form {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #1976D2;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px; text-align: left;
        }
        th { background: #f4f4f4; }
        .btn {
            display: inline-block; padding: 8px 12px;
            color: white; border: none; border-radius: 4px;
            cursor: pointer; text-decoration: none;
        }
        .btn.back { background: #007bff; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin.php">Daftar Produk</a>
        <a href="tambah_produk.php">Tambah Barang</a>
        <a href="pesan_dari_user.php">Pesan dari User</a>
        <a href="pesan_admin.php">Kirim Pesan</a>
    </div>

    <div class="content">
        <h2>📢 Kirim Pesan kepada Pengguna</h2>
        <div class="form-container">
            <form method="POST">
                <label for="user_id">ID Pengguna:</label>
                <input type="text" name="user_id" required>
                
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="proses">Sedang Diproses</option>
                    <option value="sampai">Sudah Sampai</option>
                </select>

                <label for="message">Pesan:</label>
                <textarea name="message" rows="4" required></textarea>

                <button type="submit">Kirim Notifikasi</button>
            </form>
        </div>

        <h2>📨 Daftar Pesan yang Dikirim</h2>
        <table>
            <tr>
                <th>No</th>
                <th>ID Pengguna</th>
                <th>Status</th>
                <th>Pesan</th>
                <th>Tanggal</th>
            </tr>
            <?php
            $result_pesan = $conn->query("SELECT user_id, status, message, sent_at FROM pesan_admin ORDER BY sent_at DESC");
            if ($result_pesan->num_rows > 0) {
                $no = 1;
                while ($row = $result_pesan->fetch_assoc()) {
                    echo "<tr>
                        <td>$no</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['message']}</td>
                        <td>{$row['sent_at']}</td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='5'>Belum ada pesan yang dikirim</td></tr>";
            }
            ?>
        </table>
<!-- 
        <br><br>
        <a href="admin.php" class="btn back">⬅ Kembali ke Halaman Admin</a> -->
    </div>
</body>
</html>
