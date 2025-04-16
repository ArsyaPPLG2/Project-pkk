<?php
require 'koneksi.php';

// Hapus Pesan
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql_delete = "DELETE FROM pesan_user WHERE id_pesan = $delete_id";

    if ($conn->query($sql_delete) === TRUE) {
        echo "<script>alert('Pesan berhasil dihapus!'); window.location.href = 'pesan_dari_user.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan dari User | Admin Panel</title>
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
        .btn.delete { background: red; }
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
        <h2>📩 Pesan dari User</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Pesan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php
            $result_pesan = $conn->query("SELECT id_pesan, message, sent_at FROM pesan_user");
            if ($result_pesan->num_rows > 0) {
                $no = 1;
                while ($row = $result_pesan->fetch_assoc()) {
                    $id_pesan = htmlspecialchars($row['id_pesan']);
                    $message = htmlspecialchars($row['message']);
                    $sent_at = htmlspecialchars($row['sent_at']);

                    echo "<tr>
                        <td>$no</td>
                        <td>$message</td>
                        <td>$sent_at</td>
                        <td>
                            <a href='pesan_dari_user.php?delete_id=$id_pesan' 
                               class='btn delete' 
                               onclick='return confirm(\"Yakin ingin menghapus pesan ini?\")'>
                               Hapus
                            </a>
                        </td>
                    </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada pesan</td></tr>";
            }
            ?>
        </table>

        <!-- <br><br>
        <a href="admin.php" class="btn back">⬅ Kembali ke Halaman Admin</a> -->
    </div>
</body>
</html>
