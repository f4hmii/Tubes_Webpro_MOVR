<?php
session_start();
include '../db_connection.php'; // Pastikan path ke db_connection.php sudah benar

// Pastikan user sudah login dan merupakan seller
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../pages/login.php");
    exit;
}

$seller_id = intval($_SESSION['id']);

// Mengambil pesanan yang relevan
$query = $conn->prepare("
    SELECT
        t.transaksi_id,
        t.total_harga,
        t.tanggal,
        t.alamat_pengiriman,
        t.metode_pembayaran AS id_metode_pembayaran,
        t.status_transaksi, -- Ditambahkan untuk mengambil status transaksi aktual
        mp.nama_bank,
        mp.metode AS nama_metode,
        pb.status_pembayaran,
        pb.bukti_pembayaran,
        pg_buyer.nama_pengguna AS buyer_name,
        GROUP_CONCAT(DISTINCT CONCAT(prod.nama_produk, ' (Qty: ', td.quantity, ', Ukuran: ', COALESCE(td.ukuran, '-'), ', Warna: ', COALESCE(td.warna, '-'), ')<br>Harga Satuan: Rp', FORMAT(td.harga, 0, 'id_ID')) SEPARATOR '|||') AS products_list,
        GROUP_CONCAT(DISTINCT prod.foto_url SEPARATOR '|||') AS product_photos,
        GROUP_CONCAT(DISTINCT IF(prod.verified = 1, 'Terverifikasi', 'Belum Terverifikasi') SEPARATOR '|||') AS product_verified_status
    FROM
        transaksi t
    JOIN
        pengguna pg_buyer ON t.pengguna_id = pg_buyer.pengguna_id
    JOIN
        transaksi_detail td ON t.transaksi_id = td.transaksi_id
    JOIN
        produk prod ON td.produk_id = prod.produk_id
    JOIN
        pembayaran pb ON t.transaksi_id = pb.pesanan_id
    JOIN
        metode_pembayaran mp ON pb.metode_pembayaran = mp.id
    WHERE
        prod.seller_id = ?
        AND prod.verified = 1
        AND pb.status_pembayaran = 'confirmed'
    GROUP BY
        t.transaksi_id, t.total_harga, t.tanggal, t.alamat_pengiriman, t.metode_pembayaran, t.status_transaksi, pb.status_pembayaran, pg_buyer.nama_pengguna, mp.nama_bank, mp.metode, pb.bukti_pembayaran
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
    $product_verified_status = explode('|||', $row['product_verified_status']);
    $products_info = [];
    foreach ($products_data as $index => $product_str) {
        $products_info[] = [
            'details' => $product_str,
            'photo' => $product_photos[$index] ?? 'image-not-found.png',
            'verified_status' => $product_verified_status[$index] ?? 'Belum Terverifikasi'
        ];
    }

    $orders[] = [
        'transaksi_id' => $row['transaksi_id'],
        'total_harga' => $row['total_harga'],
        'tanggal' => $row['tanggal'],
        'alamat_pengiriman' => $row['alamat_pengiriman'],
        'metode_pembayaran_detail' => $row['nama_bank'] . ' - ' . $row['nama_metode'],
        'status_pembayaran' => $row['status_pembayaran'],
        'status_transaksi' => $row['status_transaksi'], // Menyimpan status transaksi
        'bukti_pembayaran' => $row['bukti_pembayaran'],
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
    <title>Kelola Pesanan Dikonfirmasi - Seller</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6">Pesanan Terkonfirmasi & Produk Terverifikasi</h1>

    <div class="mt-6 mb-6">
        <a href="profile.php" class="inline-block px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard Seller
        </a>
    </div>

    <?php if (empty($orders)): ?>
        <p class="text-gray-600 text-lg text-center py-10">Tidak ada pesanan yang memenuhi kriteria saat ini.</p>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($orders as $order): ?>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 pb-4 border-b">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">Transaksi #<?= htmlspecialchars($order['transaksi_id']) ?></h2>
                            <p class="text-sm text-gray-500">Tanggal: <?= date("d M Y, H:i", strtotime($order['tanggal'])) ?></p>
                        </div>
                        <div>
                            <span class="mt-2 sm:mt-0 inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Pembayaran: <?= strtoupper(htmlspecialchars($order['status_pembayaran'])) ?>
                            </span>
                            <span class="mt-2 sm:mt-0 ml-2 inline-block px-3 py-1 text-xs font-semibold rounded-full 
                                <?php 
                                    if ($order['status_transaksi'] === 'shipped') echo 'bg-blue-100 text-blue-700';
                                    elseif ($order['status_transaksi'] === 'completed') echo 'bg-purple-100 text-purple-700';
                                    elseif ($order['status_transaksi'] === 'cancelled') echo 'bg-red-100 text-red-700';
                                    else echo 'bg-yellow-100 text-yellow-700'; // Default untuk 'processing' atau lainnya
                                ?>">
                                Status Pesanan: <?= strtoupper(htmlspecialchars($order['status_transaksi'])) ?>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="font-medium text-gray-700">Pembeli: <span class="font-normal"><?= htmlspecialchars($order['buyer_name']) ?></span></p>
                            <p class="font-medium text-gray-700 mt-1">Alamat Pengiriman:</p>
                            <p class="text-sm text-gray-600 leading-relaxed"><?= nl2br(htmlspecialchars($order['alamat_pengiriman'])) ?></p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-700">Metode Pembayaran: <span class="font-normal"><?= htmlspecialchars($order['metode_pembayaran_detail']) ?></span></p>
                             <?php if (!empty($order['bukti_pembayaran'])): ?>
                                <p class="font-medium text-gray-700 mt-1">Bukti Pembayaran:</p>
                                <a href="../uploads/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" target="_blank" class="text-blue-500 hover:underline">
                                    <img src="../uploads/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" width="100" class="mt-1 rounded border img-thumbnail" alt="Bukti Bayar"/>
                                </a>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 mt-1">(Bukti tidak tersedia)</p>
                            <?php endif; ?>
                            <p class="text-lg font-bold text-gray-800 mt-3">Total: Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></p>
                        </div>
                    </div>

                    <h3 class="text-md font-semibold mb-3 border-t pt-4 text-gray-700">Produk dalam Pesanan:</h3>
                    <div class="space-y-3">
                        <?php foreach ($order['products'] as $product): ?>
                            <div class="flex items-start space-x-4 p-3 bg-gray-50 rounded-md">
                                <img src="../uploads/<?= htmlspecialchars($product['photo']) ?>"
                                     alt="Foto Produk"
                                     class="w-20 h-20 object-cover rounded-md border"
                                     onerror="this.onerror=null; this.src='../uploads/image-not-found.png';">
                                <div class="flex-grow">
                                    <p class="text-sm text-gray-800 font-medium">
                                        <?= $product['details'] ?>
                                    </p>
                                    <p class="text-xs text-gray-500">Status Produk: <?= htmlspecialchars($product['verified_status']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mt-6 border-t pt-4 text-right">
                        <form action="update_order_status.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menandai pesanan ini sebagai SUDAH DIKIRIM? Aksi ini tidak dapat dibatalkan.');">
                            <input type="hidden" name="transaksi_id" value="<?= $order['transaksi_id'] ?>">
                            <input type="hidden" name="new_status" value="shipped">
                            <?php
                                $button_disabled = false;
                                $button_classes = "px-5 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors";
                                $button_text = "Tandai Sudah Dikirim";
                                $icon_class = "fas fa-truck";

                                // Periksa status_transaksi
                                // Nilai ENUM di database: 'processing', 'shipped', 'completed', 'cancelled'
                                if (isset($order['status_transaksi'])) {
                                    if ($order['status_transaksi'] === 'shipped') {
                                        $button_disabled = true;
                                        $button_classes = "px-5 py-2 bg-gray-400 text-gray-700 font-semibold rounded-lg cursor-not-allowed";
                                        $button_text = "Sudah Dikirim";
                                        $icon_class = "fas fa-check-circle"; // Icon ganti jadi centang
                                    } elseif (in_array($order['status_transaksi'], ['completed', 'cancelled'])) {
                                        $button_disabled = true;
                                        $button_classes = "px-5 py-2 bg-gray-400 text-gray-700 font-semibold rounded-lg cursor-not-allowed";
                                        if ($order['status_transaksi'] === 'completed') {
                                            $button_text = "Pesanan Selesai";
                                            $icon_class = "fas fa-star"; // Icon bintang untuk selesai
                                        } else { // cancelled
                                            $button_text = "Pesanan Dibatalkan";
                                            $icon_class = "fas fa-times-circle"; // Icon silang untuk batal
                                        }
                                    }
                                    // Jika status 'processing', tombol tetap aktif dengan teks default.
                                }
                            ?>
                            <button type="submit"
                                    class="<?= $button_classes ?>"
                                    <?= $button_disabled ? 'disabled' : '' ?>>
                                <i class="<?= $icon_class ?> mr-2"></i><?= $button_text ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>