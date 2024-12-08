<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Daftar menu makanan
$menus = [
    1 => ["name" => "Ayam Geprek", "price" => 10000],
    2 => ["name" => "Nasi Campur", "price" => 9000],
    3 => ["name" => "Nasi Kuning", "price" => 9000],
];

// Variabel untuk menu yang dipilih
$menu_id = isset($_POST['menu_id']) ? $_POST['menu_id'] : null;
$harga = 0;
$menu_name = "";

// Cek apakah ID menu valid
if ($menu_id && isset($menus[$menu_id])) {
    $menu_name = $menus[$menu_id]['name'];
    $harga = $menus[$menu_id]['price'];
}

// Proses pembayaran
$error_message = "";
$success_message = "";
$nominal_pembayaran = 0;
$kembalian = 0;

// Pastikan nominal_pembayaran hanya diambil jika ada dalam POST
if (isset($_POST['bayar']) && isset($_POST['nominal_pembayaran'])) {
    $nominal_pembayaran = $_POST['nominal_pembayaran'] ?? 0;

    if ($nominal_pembayaran < $harga) {
        $error_message = "Nominal pembayaran kurang!";
    } else {
        $kembalian = $nominal_pembayaran - $harga;
        $success_message = "Pembayaran berhasil! Kembalian: Rp " . number_format($kembalian, 0, ',', '.');
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #0d6efd; /* Warna Biru */
            background-image: 
                url('image/bg.jpg'),
                url('image/bg2.jpg');
            background-position: top left, bottom right;
            background-size: 50%, 50%;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
            z-index: 1; /* Agar kontainer tetap di atas background */
        }

        .btn-pembayaran {
            background-color: #0056b3; /* Warna biru tua */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
        }

        .btn-pembayaran:hover {
            background-color: #004085;
        }

        .alert {
            margin-bottom: 20px;
        }

        .struk-section {
            background-color: #f1f1f1;
            padding: 20px;
            margin-top: 30px;
            border-radius: 5px;
            text-align: center;
        }

        .btn-back {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-5 text-primary">Halaman Pembayaran</h2>

    <!-- Form Pembayaran -->
    <form method="POST">
        <!-- Pilih Menu -->
        <div class="mb-3">
            <label for="menu_id" class="form-label">Pilih Menu</label>
            <select class="form-select" id="menu_id" name="menu_id" required>
                <option value="" disabled selected>Pilih Menu</option>
                <?php foreach ($menus as $id => $menu): ?>
                    <option value="<?= $id ?>" <?= ($menu_id == $id) ? 'selected' : ''; ?>><?= $menu['name'] ?> - Rp <?= number_format($menu['price'], 0, ',', '.') ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Form Nominal Pembayaran (Selalu Tampil) -->
        <div class="mb-3">
            <label for="nominal_pembayaran" class="form-label">Nominal Pembayaran</label>
            <input type="number" class="form-control" id="nominal_pembayaran" name="nominal_pembayaran" value="<?= isset($nominal_pembayaran) ? $nominal_pembayaran : '' ?>" required>
        </div>

        <!-- Tombol Bayar -->
        <button type="submit" name="bayar" class="btn btn-pembayaran">Bayar</button>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?= $success_message ?></div>
        <?php endif; ?>
    </form>

    <?php if ($success_message): ?>
        <!-- Cetak Struk -->
        <div class="struk-section">
            <h5>Struk Pembayaran</h5>
            <p><strong>Menu:</strong> <?= $menu_name ?></p>
            <p><strong>Harga:</strong> Rp <?= number_format($harga, 0, ',', '.') ?></p>
            <p><strong>Nominal Pembayaran:</strong> Rp <?= number_format($nominal_pembayaran, 0, ',', '.') ?></p>
            <p><strong>Kembalian:</strong> Rp <?= number_format($kembalian, 0, ',', '.') ?></p>
        </div>
    <?php endif; ?>

    <!-- Tombol Kembali ke Dashboard -->
    <div class="text-center">
        <a href="index.php" class="btn btn-back">Kembali ke Dashboard</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
