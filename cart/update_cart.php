<?php
include '../db_connection.php';
session_start();

$item = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $keranjang_id = intval($_GET['id']);

    // Ambil data dari keranjang untuk ditampilkan
    $stmt = $conn->prepare("SELECT * FROM keranjang WHERE keranjang_id = ?");
    $stmt->bind_param("i", $keranjang_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keranjang_id = intval($_POST['keranjang_id']);
    $size = $_POST['size'];
    $quantity = intval($_POST['quantity']);

    $stmt = $conn->prepare("UPDATE keranjang SET size = ?, quantity = ? WHERE keranjang_id = ?");
    $stmt->bind_param("sii", $size, $quantity, $keranjang_id);
    $stmt->execute();

    header("Location: ../cart/cart.php"); // <-- Pastikan path sesuai
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Keranjang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10 px-4">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Edit Item</h2>

        <?php if ($item): ?>
            <form action="update_cart.php" method="POST">
                <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id'] ?>">

                <label class="block mb-2">Ukuran:</label>
                <input type="text" name="size" value="<?= htmlspecialchars($item['size']) ?>" class="w-full mb-4 px-3 py-2 border rounded">

                <label class="block mb-2">Jumlah:</label>
                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" class="w-full mb-4 px-3 py-2 border rounded">

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </form>
        <?php else: ?>
            <p class="text-red-600">Item tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>

</html>