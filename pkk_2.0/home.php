<?php
session_start();

$host = "localhost";
$user = "root"; 
$pass = "";      
$dbname = "toko_db";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$selectedCategory = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$sql = "SELECT `id_produk`, `name`, `deskripsi`, `price`, `stock`, `category_id`, `foto` FROM `products`";
if ($selectedCategory) {
    $sql .= " WHERE category_id = " . $conn->real_escape_string($selectedCategory);
}
$result = $conn->query($sql);

$sql_kategori = "SELECT `id_kategori`, `nama_kategori` FROM `kategori`";
$result_kategori = $conn->query($sql_kategori);

$loggedIn = isset($_SESSION['name']);
$username = $loggedIn ? $_SESSION['name'] : "Guest"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKOOKYU - Home</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e0e0e0;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .header, footer {
            background: linear-gradient(135deg, #6c3ea4, #b76bb3);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        a {
            color: black;
            text-decoration: none;
        }

        .header:hover, footer:hover {
            background: linear-gradient(135deg, #5b2b91, #a96f94); 
        }

        .profile {
            display: flex;
            align-items: center;
        }
        .profile span {
            margin-left: 10px;
            font-weight: bold;
            color: #c9c9f0;
        }

        .header-select, .header-search {
            display: flex;
            align-items: center;
        }

        .header-select select {
            padding: 8px 12px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background: linear-gradient(545deg, #5b2b91, #a96f94); 
            color: #333;
            cursor: pointer;
        }

        .header-search input {
            padding: 8px 12px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .header-search button {
            padding: 8px 12px;
            background-color: #6c3ea4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .header-search button:hover {
            background-color: #5b2b91;
        }

        .products {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .product {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            width: 200px;
            margin: 10px;
        }

        .product img {
            width: 100%;
            border-radius: 5px;
        }

        .product p {
            margin: 10px 0;
            font-weight: bold;
        }

        .sidebar-menu {
            position: fixed;
            top: 0;
            right: 0;
            width: 100px; 
            height: 100%;
            background-color: #fff;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
            box-shadow: -2px 0 5px rgba(0,0,0,0.5); 
            transition: right 0.3s;
        }

        .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        footer {
            justify-content: center;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .products {
                flex-direction: column;
                align-items: center;
            }

            .product {
                width: 90%;
            }

            .sidebar-menu {
                width: 150px;
            }
        }

        @media (max-width: 480px) {
            .header {
                flex-direction: column;
                align-items: center;
            }

            .products {
                flex-direction: column;
                align-items: center;
            }

            .product {
                width: 100%;
                margin: 10px 0;
            }
        }

#category {
    padding: 10px 20px;
    font-size: 16px;
    color: #333;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 250px; 
    cursor: pointer;
    transition: all 0.3s ease;
}

#category:hover {
    border-color: #6c3ea4;
    background-color: #f7f7f7;
}

#category:focus {
    outline: none;
    border-color: #6c3ea4; 
    box-shadow: 0 0 5px rgba(108, 62, 164, 0.5);
}


#category option {
    padding: 10px;
    font-size: 16px;
    background-color: #fff;
    color: #333;
}


#category option:hover {
    background-color: #6c3ea4;
    color: white;
}


@media (max-width: 768px) {
    #category {
        width: 200px;
    }
}

@media (max-width: 480px) {
    #category {
        width: 150px;
    }
}

        
    </style>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-menu');
            if (sidebar.style.display === "none" || sidebar.style.display === "") {
                sidebar.style.display = "flex"; 
            } else {
                sidebar.style.display = "none"; 
            }
        }
    </script>
</head>
<body>

<div class="header">
    <div class="profile">
        <?php if ($loggedIn): ?>
            <a href="profil.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
                <span><?php echo htmlspecialchars($username); ?></span>
            </a>
        <?php else: ?>
            <a href="login.php" style="color: white; text-decoration: none; font-weight: bold;">Login</a>
        <?php endif; ?>
    </div>

    <select name="kategori" id="category" onchange="filterByCategory()">
        <option selected disabled>Semua Kategori</option>
        <option selected disabled>Makanan</option>
        <option selected disabled>Minuman</option>
        <option selected disabled>Barang Random</option>
    <?php
    if ($result_kategori && $result_kategori->num_rows > 0) {
        while ($kategori = $result_kategori->fetch_assoc()) {
            echo '<option value="' . $kategori['id_kategori'] . '">' . htmlspecialchars($kategori['nama_kategori']) . '</option>';
        }
    }
    ?>
</select>

    <div class="header-search">
        <input type="search" placeholder="Cari produk...">
        <button type="submit">Cari</button>
    </div>

    <button onclick="toggleSidebar()" style="background: none; border: none; color: white;">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
        </svg>
    </button>
</div>



<?php if ($loggedIn): ?>
    <div class="sidebar-menu">
        
        <div class="menu-item">
            <a href="cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z"/>
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
            </a>
            <p>Cart</p>
        </div>
        <div class="menu-item">
            <a href="history.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16">
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                </svg>
            </a>
            <p>History</p>
        </div>
        <div class="menu-item">
            <a href="notif.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.273a.5.5 0 0 0 .464.685h9.316a.5.5 0 0 0 .464-.685 13.522 13.522 0 0 1-.663-2.273C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92L8 1.918zM14 12.098A14.533 14.533 0 0 0 14 12H2c0 .035-.002.07-.002.098H14z"/>
                </svg>
            </a>
            <p>Notif</p>
        </div>
        
        <div class="menu-item">
            <a href="help.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-octagon" viewBox="0 0 16 16">
  <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z"/>
  <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
</svg></a>
            <p>Help</p>
        </div>
    
        
        <div class="menu-item">
            <a href="pesan_user.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
  <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
</svg></a>
            <p>Pesan</p>
        </div>
    
        <div class="logout-button">
            <form action="logout.php" method="POST">
                <button type="submit">Log out</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<h1><a href="home.php">TOKOOKYU</a></h1>

<div class="products">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product">';
            echo '<img src="uploads/' . htmlspecialchars($row['foto']) . '" alt="Foto Produk">';
            echo '<p>' . htmlspecialchars($row['nama_produk']) . '</p>';
            echo '<p>RP. ' . number_format($row['harga'], 0, ',', '.') . '</p>';
            if ($loggedIn) {
                echo '<button><a href="detail_produk_home.php?id=' . urlencode($row['product_id']) . '">Detail</a></button>';
            } else {
                
      

                echo '<button><a href="login.php" onclick="alert(\'Silakan login terlebih dahulu untuk melihat detail produk.\')">Detail</a></button>';
            }
            echo '</div>';
        }
    } else {
        echo "<p>Tidak ada produk yang tersedia.</p>";
    }
    ?>
</div>

<script>
        let sidebarVisible = false;

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-menu');
            sidebar.style.display = sidebarVisible ? "none" : "flex"; 
            sidebarVisible = !sidebarVisible; 
        }

        function closeSidebar(event) {
            const sidebar = document.querySelector('.sidebar-menu');
            
            if (sidebarVisible && !sidebar.contains(event.target) && !event.target.closest('.header button')) {
                sidebar.style.display = "none"; 
                sidebarVisible = false;
            }
        }

        document.addEventListener('click', closeSidebar);
    </script>

        <script>
            function filterByCategory() {
    var categoryId = document.getElementById("category").value;
    window.location.href = "home.php?category=" + categoryId; 
}

        </script>

<footer>
    <p>&copy; 2024 TOKOOKYU. Semua hak dilindungi.  Di Ciptakan Oleh Arz Dan GPT</p>


</footer>
</body>
</html>

