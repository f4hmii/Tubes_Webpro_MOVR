<?php
session_start();
// sementara buat testing login seller
$_SESSION['seller_id'] = 1; 

include '../configdb.php'; // ganti sesuai koneksi kamu

// Ambil produk berdasarkan seller yang login
$seller_id = $_SESSION['seller_id'];
$query = "SELECT * FROM produk WHERE seller_id = $seller_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Produk Saya</h1>

    <a href="tambah_produk.php" class="mb-6 inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
        + Tambah Produk
    </a>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <img src="<?= htmlspecialchars($row['foto_url']); ?>" alt="Produk" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold"><?= htmlspecialchars($row['nama_produk']); ?></h2>
                    <p class="text-gray-600 mb-2">Rp<?= number_format($row['harga'], 0, ',', '.'); ?></p>
                    <p class="text-sm text-gray-500 mb-4">Stok: <?= $row['stock']; ?></p>
                    <div class="flex gap-2">
                        <a href="edit_produk.php?id=<?= $row['produk_id']; ?>" class="bg-yellow-400 hover:bg-yellow-500 text-white py-1 px-3 rounded">Edit</a>
                        <a href="hapus_produk.php?id=<?= $row['produk_id']; ?>" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded" onclick="return confirm('Yakin mau hapus produk ini?')">Hapus</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body
