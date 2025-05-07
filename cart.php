<?php
session_start();
include "db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['edit_index'])) {
    $item = [
        'product_name' => $_POST['product_name'],
        'price' => $_POST['price'],
        'size' => $_POST['size'],
        'quantity' => $_POST['quantity']
    ];
    $_SESSION['cart'][] = $item;
}

if (isset($_GET['delete'])) {
    $deleteIndex = $_GET['delete'];
    unset($_SESSION['cart'][$deleteIndex]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_index'])) {
    $index = $_POST['edit_index'];
    $_SESSION['cart'][$index] = [
        'product_name' => $_POST['product_name'],
        'price' => $_POST['price'],
        'size' => $_POST['size'],
        'quantity' => $_POST['quantity']
    ];
    header("Location: cart.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">Produk</th>
                        <th class="py-2 px-4 text-left">Ukuran</th>
                        <th class="py-2 px-4 text-left">Jumlah</th>
                        <th class="py-2 px-4 text-left">Harga</th>
                        <th class="py-2 px-4 text-left">Subtotal</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['cart'] as $index => $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;


                        if (isset($_GET['edit']) && $_GET['edit'] == $index):
                    ?>
                            <form method="POST" action="cart.php">
                                <input type="hidden" name="edit_index" value="<?= $index ?>">
                                <tr class="bg-yellow-100">
                                    <td class="py-2 px-4">
                                        <?= htmlspecialchars($item['product_name']) ?>
                                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($item['product_name']) ?>">
                                    </td>
                                    <td class="py-2 px-4"><input name="size" class="border p-1 w-full" value="<?= htmlspecialchars($item['size']) ?>"></td>
                                    <td class="py-2 px-4"><input type="number" name="quantity" class="border p-1 w-full" value="<?= $item['quantity'] ?>"></td>
                                    <td class="py-2 px-4">
                                        <input type="number" name="price" class="border p-1 w-full" value="<?= $item['price'] ?>">
                                    </td>

                                    <td class="py-2 px-4">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                    <td class="py-2 px-4">
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Simpan</button>
                                        <a href="cart.php" class="ml-2 text-red-500">Batal</a>
                                    </td>
                                </tr>
                            </form>
                        <?php else: ?>
                            <tr>
                                <td class="py-2 px-4"><?= htmlspecialchars($item['product_name']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($item['size']) ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($item['quantity']) ?></td>
                                <td class="py-2 px-4">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                <td class="py-2 px-4">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                <td class="py-2 px-4">
                                    <a href="cart.php?edit=<?= $index ?>" class="text-blue-500">Edit</a> |
                                    <a href="cart.php?delete=<?= $index ?>" onclick="return confirm('Hapus item ini?')" class="text-red-500">Hapus</a>
                                </td>
                            </tr>
                    <?php endif;
                    endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4 text-right font-bold text-lg">
                Total: Rp <?= number_format($total, 0, ',', '.') ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Keranjang masih kosong.</p>
        <?php endif; ?>
    </div>
    <script>
        function updateSubtotal(input, index) {
            const quantity = parseInt(input.value) || 0;
            const price = parseInt(input.dataset.price);
            const subtotal = quantity * price;

            // Update subtotal display
            const subtotalElement = document.getElementById('subtotal-' + index);
            subtotalElement.innerText = formatRupiah(subtotal);

            // Update total
            let total = 0;
            document.querySelectorAll('.quantity-input').forEach(el => {
                const qty = parseInt(el.value) || 0;
                const prc = parseInt(el.dataset.price);
                total += qty * prc;
            });
            document.getElementById('cart-total').innerText = formatRupiah(total);
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number).replace('Rp', 'Rp ');
        }
    </script>

</body>

</html>