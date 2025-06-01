<?php
session_start();
include '../db_connection.php'; // Pastikan path ke db_connection.php sudah benar

// Pastikan user sudah login dan merupakan seller
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../pages/login.php");
    exit;
}

$seller_id = intval($_SESSION['id']);

// Mengambil pesanan yang perlu diproses oleh seller
// Ini adalah pesanan yang sudah 'paid' dan belum 'shipped' atau 'completed'
$query = $conn->prepare("
    SELECT
        t.transaksi_id,
        t.total_harga,
        t.tanggal,
        t.alamat_pengiriman,
        t.metode_pembayaran,
        t.status_pembayaran,
        p.nama_pengguna AS buyer_name,
        GROUP_CONCAT(CONCAT(prod.nama_produk, ' (', td.quantity, 'x) - Ukuran: ', td.ukuran, ', Warna: ', td.warna, ' @ Rp', FORMAT(td.harga, 0, 'id_ID')) SEPARATOR '|||') AS products_list,
        GROUP_CONCAT(prod.foto_url SEPARATOR '|||') AS product_photos
    FROM
        transaksi t
    JOIN
        pengguna p ON t.pengguna_id = p.pengguna_id
    JOIN
        transaksi_detail td ON t.transaksi_id = td.transaksi_id
    JOIN
        produk prod ON td.produk_id = prod.produk_id
    WHERE
        prod.seller_id = ?
        AND t.status_pembayaran IN ('paid') -- Hanya yang sudah dibayar dan siap diproses
    GROUP BY
        t.transaksi_id, t.total_harga, t.tanggal, t.alamat_pengiriman, t.metode_pembayaran, t.status_pembayaran, p.nama_pengguna
    ORDER BY
        t.tanggal DESC
");
$query->bind_param("i", $seller_id);
$query->execute();
$result = $query->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $products_data = explode('|||', $row['products_list']);
    $product_photos = explode('|||', $row['product_photos']);
    $products_info = [];
    foreach ($products_data as $index => $product_str) {
        $products_info[] = [
            'details' => $product_str,
            'photo' => $product_photos[$index] ?? 'image-not-found.png' // Fallback jika tidak ada foto
        ];
    }

    $orders[] = [
        'transaksi_id' => $row['transaksi_id'],
        'total_harga' => $row['total_harga'],
        'tanggal' => $row['tanggal'],
        'alamat_pengiriman' => $row['alamat_pengiriman'],
        'metode_pembayaran' => $row['metode_pembayaran'],
        'status_transaksi' => $row['status_transaksi'],
        'buyer_name' => $row['buyer_name'],
        'products' => $products_info
    ];
}
$query->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6">Pesanan Perlu Diproses</h1>

    <div class="mt-6 mb-6">
        <a href="profile.php" class="inline-block px-4 py-2 bg-black text-white rounded hover:bg-gray-500">
            Kembali ke Dashboard
        </a>
    </div>

    <?php if (empty($orders)): ?>
        <p class="text-gray-600 text-lg">Tidak ada pesanan yang perlu diproses saat ini.</p>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($orders as $order): ?>
                <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Transaksi #<?= htmlspecialchars($order['transaksi_id']) ?></h2>
                            <p class="text-sm text-gray-500">Tanggal: <?= htmlspecialchars($order['tanggal']) ?></p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                            <?= $order['status_transaksi'] == 'paid' ? 'bg-green-100 text-green-800' :
                               ($order['status_transaksi'] == 'shipped' ? 'bg-blue-100 text-blue-800' :
                                'bg-gray-100 text-gray-800') ?>">
                            <?= strtoupper(htmlspecialchars($order['status_transaksi'])) ?>
                        </span>
                    </div>

                    <div class="mb-4">
                        <p class="font-medium text-gray-700">Pembeli: <?= htmlspecialchars($order['buyer_name']) ?></p>
                        <p class="text-sm text-gray-600">Alamat Pengiriman: <?= nl2br(htmlspecialchars($order['alamat_pengiriman'])) ?></p>
                        <p class="text-sm text-gray-600">Metode Pembayaran: <?= htmlspecialchars($order['metode_pembayaran']) ?></p>
                        <p class="text-lg font-bold text-gray-800 mt-2">Total: Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></p>
                    </div>

                    <h3 class="text-lg font-semibold mb-3 border-t pt-4">Produk dalam Pesanan:</h3>
                    <div class="space-y-3">
                        <?php foreach ($order['products'] as $product): ?>
                            <div class="flex items-start space-x-3">
                                <img src="../uploads/<?= htmlspecialchars($product['photo']) ?>"
                                     alt="Produk"
                                     class="w-16 h-16 object-cover rounded-md flex-shrink-0"
                                     onerror="this.onerror=null; this.src='../uploads/image-not-found.png';">
                                <p class="text-sm text-gray-700 flex-grow">
                                    <?= htmlspecialchars(str_replace(' @ Rp', ' - Rp', $product['details'])) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6 border-t pt-4 text-right">
                        <form action="update_order_status.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menandai pesanan ini sebagai SUDAH DIKIRIM? Aksi ini tidak dapat dibatalkan.');">
                            <input type="hidden" name="transaksi_id" value="<?= $order['transaksi_id'] ?>">
                            <input type="hidden" name="new_status" value="shipped">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Tandai Sudah Dikirim
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>