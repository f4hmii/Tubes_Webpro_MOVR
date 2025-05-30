<?php
include '../db_connection.php';
session_start();

// Anggap pengguna sudah login dan memiliki ID
// Ganti `$_SESSION['pengguna_id']` dengan ID pengguna sebenarnya
$pengguna_id = $_SESSION['pengguna_id'] ?? 1; // default sementara

// Proses data dari form jika ada pengiriman POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $produk_id = intval($_POST['produk_id']);
  $color = $_POST['color'];
  $size = $_POST['size'];
  $quantity = intval($_POST['quantity']);

  // Cek apakah produk sudah ada di keranjang user dengan warna dan ukuran yang sama
  $stmt = $conn->prepare("SELECT * FROM keranjang WHERE pengguna_id = ? AND produk_id = ? AND color = ? AND size = ?");
  $stmt->bind_param("iiss", $pengguna_id, $produk_id, $color, $size);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Jika produk sudah ada, update quantity
    $stmtUpdate = $conn->prepare("UPDATE keranjang SET quantity = quantity + ? WHERE pengguna_id = ? AND produk_id = ? AND color = ? AND size = ?");
    $stmtUpdate->bind_param("iiiss", $quantity, $pengguna_id, $produk_id, $color, $size);
    $stmtUpdate->execute();
  } else {
    // Jika belum ada, insert data baru
    $stmtInsert = $conn->prepare("INSERT INTO keranjang (pengguna_id, produk_id, color, size, quantity) VALUES (?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("iissi", $pengguna_id, $produk_id, $color, $size, $quantity);
    $stmtInsert->execute();
  }
}

// Ambil isi keranjang untuk ditampilkan
$stmtCart = $conn->prepare("SELECT k.*, p.nama_produk, p.harga, p.foto_url FROM keranjang k JOIN produk p ON k.produk_id = p.produk_id WHERE k.pengguna_id = ?");
$stmtCart->bind_param("i", $pengguna_id);
$stmtCart->execute();
$cartItems = $stmtCart->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <div class="max-w-5xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

    <?php if ($cartItems->num_rows > 0): ?>
      <div class="bg-white p-6 rounded shadow">
        <table class="w-full table-auto">
          <thead>
            <tr class="bg-gray-200">
              <th class="px-4 py-2">Gambar</th>
              <th class="px-4 py-2">Nama Produk</th>
              <th class="px-4 py-2">Warna</th>
              <th class="px-4 py-2">Ukuran</th>
              <th class="px-4 py-2">Jumlah</th>
              <th class="px-4 py-2">Harga</th>
              <th class="px-4 py-2">Total</th>
              <!-- Tambah kolom aksi -->
              <th class="px-4 py-2">Aksi</th>

            </tr>
          </thead>
          <tbody>
            <?php
            $grandTotal = 0;
            while ($item = $cartItems->fetch_assoc()):
              $total = $item['harga'] * $item['quantity'];
              $grandTotal += $total;
            ?>
              <tr class="border-t">
                <td class="px-4 py-2">
                  <img src="uploads/<?= htmlspecialchars($item['foto_url']) ?>" class="w-16 h-16 object-cover rounded" alt="gambar">
                </td>
                <td class="px-4 py-2"><?= htmlspecialchars($item['nama_produk']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($item['color']) ?></td>

                <!-- View Mode -->
                <td class="px-4 py-2 view-<?= $item['keranjang_id'] ?>"><?= htmlspecialchars($item['size']) ?></td>
                <td class="px-4 py-2 view-<?= $item['keranjang_id'] ?>"><?= $item['quantity'] ?></td>

                <!-- Edit Mode -->
                <form action="../update_cart.php" method="POST" class="contents">
                  <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id'] ?>">

                  <td class="px-4 py-2 hidden edit-<?= $item['keranjang_id'] ?>">
                    <input type="text" name="size" value="<?= htmlspecialchars($item['size']) ?>" class="border rounded px-2 py-1 w-20">
                  </td>
                  <td class="px-4 py-2 hidden edit-<?= $item['keranjang_id'] ?>">
                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" class="border rounded px-2 py-1 w-16">
                  </td>

                  <!-- Harga dan total -->
                  <td class="px-4 py-2">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                  <td class="px-4 py-2">Rp <?= number_format($item['harga'] * $item['quantity'], 0, ',', '.') ?></td>

                  <!-- Tombol Aksi -->
                  <td class="px-4 py-2">
                    <button type="button" onclick="enableEdit(<?= $item['keranjang_id'] ?>)" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded view-<?= $item['keranjang_id'] ?>">Edit</button>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded hidden edit-<?= $item['keranjang_id'] ?>">Simpan</button>
                  </td>
                </form>

                <td class="px-4 py-2">
                  <form action="../hapus_cart.php" method="POST" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                    <input type="hidden" name="keranjang_id" value="<?= $item['keranjang_id'] ?>">
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                  </form>
                </td>
              </tr>


            <?php endwhile; ?>
          </tbody>
        </table>
        <div class="text-right mt-6 text-xl font-semibold">
          Total Belanja: Rp <?= number_format($grandTotal, 0, ',', '.') ?>
        </div>
      </div>
    <?php else: ?>
      <p class="text-gray-600">Keranjang Anda kosong.</p>
    <?php endif; ?>
  </div>
  <script>
    function enableEdit(rowId) {
      document.querySelectorAll('.view-' + rowId).forEach(el => el.classList.add('hidden'));
      document.querySelectorAll('.edit-' + rowId).forEach(el => el.classList.remove('hidden'));
    }
  </script>

</body>

</html>