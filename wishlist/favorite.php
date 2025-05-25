<?php
session_start();
require_once '../db_connection.php';

if (!isset($_SESSION['pengguna_id'])) {
    header("Location: login.php");
    exit();
}

$pengguna_id = $_SESSION['pengguna_id'];
$produk_id = $_POST['produk_id'] ?? null;

if ($produk_id && is_numeric($produk_id)) {
    // Cek apakah produk sudah ada di favorit
    $check = $conn->prepare("SELECT * FROM favorit WHERE pengguna_id = ? AND produk_id = ?");
    $check->bind_param("ii", $pengguna_id, $produk_id);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows === 0) {
        // Tambahkan ke favorit
        $insert = $conn->prepare("INSERT INTO favorit (pengguna_id, produk_id, quantity) VALUES (?, ?, 1)");
        $insert->bind_param("ii", $pengguna_id, $produk_id);
        $insert->execute();
    }
}


// Ambil data produk favorit
$query = $conn->prepare("
    SELECT p.produk_id, p.nama_produk, p.harga, p.foto_url, p.deskripsi
    FROM favorit f
    JOIN produk p ON f.produk_id = p.produk_id
    WHERE f.pengguna_id = ?
");
$query->bind_param("i", $pengguna_id);
$query->execute();
$result = $query->get_result();


?>

<!DOCTYPE html>
<html>

<head>
    <title>Halaman Favorit</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6">Produk Favorit Anda</h1>

    <?php if ($result->num_rows > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="border p-4 rounded mb-4">
                    <img src="<?= $product['foto_url'] ?>" alt="<?= $product['nama_produk'] ?>" class="w-32 h-32 object-cover mb-2">
                    <h2 class="text-lg font-semibold"><?= $product['nama_produk'] ?></h2>
                    <p class="text-gray-600">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                    <p class="text-sm text-gray-500"><?= $product['deskripsi'] ?></p>

                    <!-- ✅ Form hapus dari favorit -->
                    <form action="wishlist/delete_favorite.php" method="POST" class="mt-2">
                        <input type="hidden" name="produk_id" value="<?= $product['produk_id'] ?>">
                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus dari Favorit</button>
                    </form>
                </div>
            <?php endwhile; ?>

        </div>
    <?php else: ?>
        <p class="text-gray-600 text-lg">Belum ada produk favorit.</p>
    <?php endif; ?>
</body>

</html>