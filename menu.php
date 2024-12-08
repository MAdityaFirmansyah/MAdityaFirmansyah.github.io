<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
        }
        .container {
            margin-top: 50px;
        }
        .menu-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            background-color: #fff;
        }
        .menu-card img {
            width: 100%;
            height: auto;
        }
        .menu-card-body {
            padding: 15px;
        }
        .menu-card-title {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }
        .menu-card-price {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 15px;
        }
        .btn-order {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-order:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-5 text-primary">Menu Makanan</h2>
    <div class="row justify-content-center">
        <!-- Menu 1 -->
        <div class="col-md-4 mb-4">
            <div class="menu-card">
                <img src="image/geprek.jpg" alt="Menu 1">
                <div class="menu-card-body">
                    <h5 class="menu-card-title">Ayam Geprek</h5>
                    <p class="menu-card-price">Rp 10.000</p>
                    <a href="pembayaran.php" class="btn-order">Pesan Sekarang</a>
                </div>
            </div>
        </div>
        
        <!-- Menu 2 -->
        <div class="col-md-4 mb-4">
            <div class="menu-card">
                <img src="image/nasi campur.jpg" alt="Menu 2">
                <div class="menu-card-body">
                    <h5 class="menu-card-title">Nasi Campur</h5>
                    <p class="menu-card-price">Rp 9.000</p>
                    <a href="pembayaran.php" class="btn-order">Pesan Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Menu 3 -->
        <div class="col-md-4 mb-4">
            <div class="menu-card">
                <img src="image/kuning.jpg" alt="Menu 3">
                <div class="menu-card-body">
                    <h5 class="menu-card-title">Nasi Kuning</h5>
                    <p class="menu-card-price">Rp 9.000</p>
                    <a href="pembayaran.php" class="btn-order">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali ke Dashboard -->
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary">Kembali ke Dashboard</a>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>