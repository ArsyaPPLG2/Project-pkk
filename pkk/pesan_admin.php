<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Notifikasi</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            text-align: center;
        }
        .notification-form {
            margin-top: 20px;
            text-align: left;
        }
        .notification-form input,
        .notification-form textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        .notification-form button {
            background-color:rgb(0, 128, 4);
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }
        .notification-form button:hover {
            background-color: #1976D2;
        }
        .notification-message {
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kirim Notifikasi kepada Pengguna</h2>
        <div class="notification-form">
            <form id="notificationForm">
                <label for="user_id">ID Pengguna:</label>
                <input type="text" name="user_id" required>
                
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="proses">Sedang Diproses</option>
                    <option value="sampai">Sudah Sampai</option>
                </select>
                <br><br>
                <label for="message">Pesan:</label>
                <textarea name="message" rows="4" required></textarea>

                <button type="submit">Kirim Notifikasi</button>
            </form>
            <div class="notification-message" id="notificationMessage"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#notificationForm').submit(function(event) {
                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'send_notif.php', 
                    data: $(this).serialize(),
                    success: function(response) {
                        const res = JSON.parse(response);
                        if (res.status === 'success') {
                            $('#notificationMessage').text(res.message).css('color', 'green').show();
                            $('#notificationForm')[0].reset(); 

                            setTimeout(function() {
                                window.location.href = 'admin.php'; 
                            }, 2000);
                        }
                    },
                    error: function() {
                        $('#notificationMessage').text('Terjadi kesalahan saat mengirim notifikasi.').css('color', 'red').show();
                    }
                });
            });
        });
    </script>
</body>
</html>
