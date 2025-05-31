<?php
session_start();
include 'db_connection.php';
include "../view/header.php";

if (!isset($_SESSION['id'])) {
    die("Silakan login terlebih dahulu.");
}
$pengguna_id = intval($_SESSION['id']);

// Ambil data cart user
$stmt = $conn->prepare("
    SELECT c.*, p.nama_produk, p.foto_url 
    FROM cart c 
    JOIN produk p ON c.produk_id = p.produk_id 
    WHERE c.pengguna_id = ?
");
$stmt->bind_param("i", $pengguna_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
$totalHarga = 0;

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
    $totalHarga += $row['harga'] * $row['quantity'];
}

// Jika ada produk di cart, proses checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && count($items) > 0) {
    // 1. Insert ke transaksi
    $stmtTransaksi = $conn->prepare("INSERT INTO transaksi (pengguna_id, total_harga) VALUES (?, ?)");
    $stmtTransaksi->bind_param("ii", $pengguna_id, $totalHarga);
    $stmtTransaksi->execute();
    $transaksi_id = $stmtTransaksi->insert_id;

    // 2. Insert tiap item ke transaksi_detail
    $stmtDetail = $conn->prepare("INSERT INTO transaksi_detail (transaksi_id, produk_id, quantity, harga, ukuran, warna) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($items as $item) {
        $stmtDetail->bind_param(
            "iiisss",
            $transaksi_id,
            $item['produk_id'],
            $item['quantity'],
            $item['harga'],
            $item['size'],
            $item['color']
        );
        $stmtDetail->execute();
    }

    // 3. Kosongkan cart
    $stmtClearCart = $conn->prepare("DELETE FROM cart WHERE pengguna_id = ?");
    if ($stmtClearCart) {
        $stmtClearCart->bind_param("i", $pengguna_id);
        $stmtClearCart->execute();
        $stmtClearCart->close();
    } else {
        die("Gagal menghapus keranjang: " . $conn->error);
    }


    // Redirect ke halaman sukses atau nota
    header("Location: checkout_success.php?transaksi_id=$transaksi_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Checkout</h2>

        <?php if (count($items) > 0): ?>
            <form method="POST">
                <?php foreach ($items as $item): ?>
                    <div class="flex justify-between items-center py-3 border-b">
                        <div class="flex items-center gap-4">
                            <img src="../uploads/<?= htmlspecialchars($item['foto_url']) ?>" class="w-16 h-16 object-cover rounded" alt="<?= htmlspecialchars($item['nama_produk']) ?>">
                            <div>
                                <p class="font-semibold"><?= htmlspecialchars($item['nama_produk']) ?></p>
                                <p class="text-sm text-gray-600">Ukuran: <?= htmlspecialchars($item['size']) ?> | Warna: <?= htmlspecialchars($item['color']) ?></p>
                                <p class="text-sm text-gray-600">Jumlah: <?= $item['quantity'] ?></p>
                            </div>
                        </div>
                        <div class="font-semibold text-gray-800">Rp <?= number_format($item['harga'] * $item['quantity'], 0, ',', '.') ?></div>
                    </div>
                <?php endforeach; ?>

                <div class="flex justify-between mt-6 text-lg font-semibold">
                    <span>Total:</span>
                    <span>Rp <?= number_format($totalHarga, 0, ',', '.') ?></span>
                </div>

                <button type="submit" class="mt-6 w-full bg-green-600 text-white py-3 rounded hover:bg-green-700">Bayar Sekarang</button>
            </form>
        <?php else: ?>
            <p class="text-gray-600">Tidak ada produk untuk checkout.</p>
        <?php endif; ?>
    </div>
</body>

</html>