<?php
session_start();
$host = "localhost";
$user = "root"; 
$pass = "";
$dbname = "ecommerce";


$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_id = $_POST['user_id']; 
    $status = $_POST['status'];
    $message = $_POST['message']; 

    if (!isset($_SESSION['notifications'])) {
        $_SESSION['notifications'] = [];
    }

    $_SESSION['notifications'][] = [
        'type' => ($status == 'sampai') ? 'success' : 'info', 
        'title' => "Pesanan Anda",
        'message' => $message 
    ];

    echo json_encode(['status' => 'success', 'message' => 'Notifikasi berhasil dikirim.']);
    exit();
}

?>
