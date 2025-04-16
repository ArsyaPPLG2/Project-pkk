<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #6A0DAD;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-link {
            margin-top: 15px;
            font-size: 12px;
        }
        .login-link a {
            color: #6A0DAD;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>REGISTER</h2>
    <form action="proses_register.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Example@gmail.com" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="kode_rahasi" placeholder="Kode Rahasia (untuk admin)" optional>
        <input type="submit" value="Register">
    </form>
    <div class="login-link">
        already have an account? <a href="login.php">Login here</a>
    </div>
</div>

</body>
</html>
