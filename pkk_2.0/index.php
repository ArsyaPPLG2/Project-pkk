<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOKOOKYU - Home (Sebelum Login)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0e0e0;
            margin: 0;
            padding: 0;
        }
        a{
            color : black;
            text-decoration : none;
        }
        .header {
        background: linear-gradient(135deg, #6c3ea4, #b76bb3); /* Gradient background */
        color: white;
        padding: 15px 20px; /* Padding yang sedikit lebih besar */
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek kedalaman */
        transition: background 0.3s ease; /* Transisi halus untuk perubahan latar belakang */
        }

        .header:hover {
        background: linear-gradient(135deg, #5b2b91, #a96f94); /* Gradient saat hover */
        }
        .search-box {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        .search-box input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .search-box input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            padding: 10px;
            margin-left: 5px;
            border-radius: 5px;
        }
        .products {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        .product {
            background-color: white;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            width: 200px;
        }
        .product img {
            width: 100%;
            border-radius: 5px;
        }
        .product p {
            margin: 10px 0;
            font-weight: bold;
        }
        .login {
            padding: 10px; 
            background-color: #d9534f;
            color: white;
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
    </style>
</head>
<body>

    <div class="header">

        <h1><a href="index.php">TOKOOKYU</a></h1>
        <form action="login.php" method="post">
            <button type="submit" class="login">LOGIN</button>
        </form>
    </div>

    <div class="search-box">
        <input type="text" placeholder="Search Here">
        <input type="submit"  value="Search">
    </div>

    <div class="products">
        <div class="product">
            <img src="kopi.jpeg" alt="Kopi">
            <p>RP. 20.000</p>
            <p>Kopi</p>
            <button><a href="kopi.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="makaroni.jpeg" alt="makaroni">
            <p>RP. 20.000</p>
            <p>makaroni</p>
            <button><a href="makaroni.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="nasi.jpeg" alt="Paket Nasi">
            <p>RP. 20.000</p>
            <p>Paket Nasi</p>
            <button><a href="nasi.php">Detail</a></button>
        </div>
    </div>
    <div class="products">
        <div class="product">
            <img src="kopi.jpeg" alt="Kopi">
            <p>RP. 20.000</p>
            <p>Kopi</p>
            <button><a href="kopi.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="makaroni.jpeg" alt="makaroni">
            <p>RP. 20.000</p>
            <p>makaroni</p>
            <button><a href="makaroni.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="nasi.jpeg" alt="Paket Nasi">
            <p>RP. 20.000</p>
            <p>Paket Nasi</p>
            <button><a href="nasi.php">Detail</a></button>
        </div>
    </div>
    <div class="products">
        <div class="product">
            <img src="kopi.jpeg" alt="Kopi">
            <p>RP. 20.000</p>
            <p>Kopi</p>
            <button><a href="kopi.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="makaroni.jpeg" alt="makaroni">
            <p>RP. 20.000</p>
            <p>makaroni</p>
            <button><a href="makaroni.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="nasi.jpeg" alt="Paket Nasi">
            <p>RP. 20.000</p>
            <p>Paket Nasi</p>
            <button><a href="nasi.php">Detail</a></button>
        </div>
    </div>
    <div class="products">
        <div class="product">
            <img src="kopi.jpeg" alt="Kopi">
            <p>RP. 20.000</p>
            <p>Kopi</p>
            <button><a href="kopi.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="makaroni.jpeg" alt="makaroni">
            <p>RP. 20.000</p>
            <p>makaroni</p>
            <button><a href="makaroni.php">Detail</a></button>
        </div>
        <div class="product">
            <img src="nasi.jpeg" alt="Paket Nasi">
            <p>RP. 20.000</p>
            <p>Paket Nasi</p>
            <button><a href="nasi.php">Detail</a></button>
        </div>
    </div>


</body>
</html>
