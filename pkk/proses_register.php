<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'ecommerce');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['name']) &&isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['kode_rahasi'])) {
  
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $kode_rahasia = $_POST['kode_rahasia'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $role = 'user'; 
    $kode_rahasia_admin = 'ADMINtoko';
    
    if ($kode_rahasia === $kode_rahasia_admin) {
        $role = 'admin';
    }

    $stmt = $conn->prepare("INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sssss", $name, $username, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "User registered successfully!";
            header("Location: login.php");      exit();
        } else {
            echo "Error: " . $stmt->error; 
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error; 
        }

    $conn->close();
} else {
    echo "All fields are required."; 
}
?>


