<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$query = "SELECT id, username, name, email, phone, profile_picture FROM user WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = $_FILES['profile_picture']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture);

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            $updateQuery = "UPDATE user SET name=?, email=?, phone=?, profile_picture=? WHERE username=?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sssss", $name, $email, $phone, $profile_picture, $username);
        } else {
            echo "Gagal mengupload foto.";
            exit();
        }
    } else {
        $updateQuery = "UPDATE user SET name=?, email=?, phone=? WHERE username=?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssss", $name, $email, $phone, $username);
    }

    if ($stmt->execute()) {
        header("Location: profil.php");
        exit();
    } else {
        echo "Gagal memperbarui data: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #a084ca;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
            top: 0;
            left: -250px;
            transition: 0.3s;
        }

        .sidebar.show {
            left: 0;
        }

        .sidebar h2 {
    font-size: 24px;
    margin-bottom: 30px;
    margin-top: 50px; 
}


        .sidebar a {
            text-decoration: none;
            color: white;
            display: block;
            margin: 10px 0;
            font-size: 18px;
        }

        .sidebar a:hover {
            color: #d4a5ff;
        }

        .container {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
            flex: 1;
            overflow-y: auto;
        }

        .profile-wrapper {
            background-color: #e7e7ff;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-wrapper img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .profile-info {
            flex: 1;
        }

        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            background-color: #6a0dad;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #5c0ba1;
        }

        .about-platform {
            margin-top: 20px;
            background-color: #f3f3f3;
            padding: 20px;
            border-radius: 10px;
        }

        .about-platform h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .about-platform p {
            font-size: 16px;
            line-height: 1.6;
        }

        .menu-bar {
            font-size: 15px; 
            color: #a084ca;
            padding: 8px 15px; 
            cursor: pointer;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1;
            background-color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                margin-left: 0;
            }

            .sidebar {
                left: -250px;
                position: absolute;
            }

            .sidebar.show {
                left: 0;
            }

            .profile-wrapper {
                flex-direction: column;
                text-align: center;
            }

            .profile-wrapper img {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="menu-bar" onclick="toggleSidebar()">&#9776; Menu</div>

<div class="sidebar" id="sidebar">
    
    <h2><a href="home.php">TOKOOKYU</a></h2>
    <p><?php echo $user['username']; ?></p>
    <a href="saldo.php">Saldo Saya</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container" id="container">
    <div class="profile-wrapper">
        <div>
            <?php if ($user['profile_picture']): ?>
                <img src="uploads/<?php echo $user['profile_picture']; ?>" alt="Foto Profil">
            <?php else: ?>
                <img src="uploads/default.png" alt="Foto Default">
            <?php endif; ?>
            <form action="profil.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_picture">
        </div>

        <div class="profile-info">
            <label>Nama:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label>No. Telepon:</label>
            <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>

            <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>

    <div class="about-platform">
        <h3>Tentang Platform</h3>
<p>Tokookyu adalah platform yang menyediakan layanan jual beli berbagai produk secara online. </p>
<p>Kami berkomitmen untuk memberikan pengalaman berbelanja yang mudah, aman, dan menyenangkan bagi semua penggunanya.</p>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("show");
        document.getElementById("container").classList.toggle("shifted");
    }
</script>

</body>
</html>

