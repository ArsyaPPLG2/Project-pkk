<?php
session_start();
include "koneksi.php";

$query = isset($_GET['query']) ? $_GET['query'] : '';

if ($query != '') {
    $stmt = $koneksi->prepare("SELECT * FROM products WHERE nama LIKE ?");
    $searchTerm = "%$query%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $koneksi->query("SELECT * FROM product LIMIT 8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
     <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #d3d3d3;">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-store"></i> TokoKami</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="halaman_user.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="keranjang.php">
                        <i class="fas fa-shopping-cart"></i> Keranjang
                        <?php
                        if (isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0) {
                            $total_produk = count($_SESSION['keranjang']);
                            echo "<span class='badge bg-danger'>$total_produk</span>";
                        } else {
                            echo "<span class='badge bg-danger' style='display:none;'>0</span>";
                        }
                        ?>
                    </a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a class="nav-link" href="logout.php">Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="login.php">Login</a>
                    <?php endif; ?>
                </li>
            </ul>

            <form class="d-flex" action="pencarian.php" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Cari Produk..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
        </div>
    </div>
</nav>



    <div class="container mt-4">
        <h2>Hasil Pencarian</h2>
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="uploads/<?php echo $row['foto']; ?>" class="card-img-top" alt="Gambar Produk" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                                <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                                <p class="card-text"><strong>Harga: </strong>Rp. <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>

                                <div class="btn-group">
                                    <a href="#" class="btn btn-warning btn-custom" onclick="tambahKeKeranjang(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                    </a>
                                    <a href="checkout.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-custom">
                                        Beli Sekarang
                                    </a>
                                </div>
                                <a href="ha_detail_produk.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-custom">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Tidak ada produk yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
