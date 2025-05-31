<?php
include "view/header.php";
$transaksi_id = $_GET['transaksi_id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow text-center">
        <h2 class="text-2xl font-semibold text-green-600">Checkout Berhasil!</h2>
        <p class="mt-4 text-gray-700">Terima kasih telah melakukan pembelian.</p>
        <p class="mt-2">Nomor Transaksi: <strong>#<?= htmlspecialchars($transaksi_id) ?></strong></p>
        <a href="index.php" class="inline-block mt-6 px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700">Kembali ke Beranda</a>
    </div>
</body>

</html>