<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .notification-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .notification {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .notification.success {
            border-color: #4CAF50;
            background-color: #e8f5e9;
        }
        .notification.info {
            border-color: #2196F3;
            background-color: #e3f2fd;
        }
    </style>
</head>
<body>
    <div class="notification-container">
    <button onclick="history.back()">←</button>
        <h2>Notifikasi Anda</h2>

        <?php if (isset($_SESSION['notifications']) && count($_SESSION['notifications']) > 0): ?>
            <?php foreach ($_SESSION['notifications'] as $notification): ?>
                <div class="notification <?php echo $notification['type']; ?>">
                    <strong><?php echo $notification['title']; ?></strong>
                    <p><?php echo $notification['message']; ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada notifikasi.</p>
        <?php endif; ?>
    </div>
</body>
</html>
