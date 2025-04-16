<?php
session_start();

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'toko_db');

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan input tidak kosong
if (!empty($_POST['name']) && !empty($_POST['password'])) {
    $username = htmlspecialchars(trim($_POST['name']));
    $password = trim($_POST['password']);

    // Siapkan query untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT password, role FROM users WHERE name = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Cek apakah username ada di database
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $role);
            $stmt->fetch();

            // Verifikasi password
            if (password_verify($password, $hashed_password)) {
                session_regenerate_id(true); // Cegah session fixation

                $_SESSION['name'] = $username;
                $_SESSION['role'] = $role;

                // Tutup koneksi sebelum redirect
                $stmt->close();
                $conn->close();

                // Redirect sesuai role
                if ($role === 'admin') {
                    header("Location: admin.php");
                    exit();
                } elseif ($role === 'customer') {
                    header("Location: home.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Role tidak dikenal.";
                    header("Location: login.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Password salah.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Username atau password salah.";
            header("Location: login.php");
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Error pada query: " . $conn->error;
        header("Location: login.php");
        exit();
    }

    $conn->close();
} else {
    $_SESSION['error'] = "Semua kolom harus diisi.";
    header("Location: login.php");
    exit();
}
?>
