<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
 
                session_regenerate_id(true);

                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                if ($role === 'admin') {
                    header("Location: admin.php");
                } elseif ($role === 'user') {
                    header("Location: home.php");
                } else {
                    echo "Role tidak dikenal.";
                }
                exit();
            } else {
                echo "Password salah.";
            }
        } else {
            echo "Username atau password salah.";
        }

        $stmt->close();
    } else {
        echo "Error pada query: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Semua kolom harus diisi.";
}
?>
