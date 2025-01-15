<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        input[type="text"], input[type="password"] {
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
        .register-link {
            margin-top: 15px;
            font-size: 12px;
        }
        .register-link a {
            color: #6A0DAD;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>LOGIN</h2>
    <form action="proses_login.php" method="post">
        <input type="text" name="username" placeholder="Enter username" value="" autocomplete="new-username" required>
        <input type="password" name="password"  placeholder="Enter password" value="" autocomplete="new-password" required>
        <input type="submit" value="Login">
    </form>

    <div class="register-link">
        don't have an account yet? <a href="register.php">Create here</a>
    </div>
</div>

</body>
</html>
