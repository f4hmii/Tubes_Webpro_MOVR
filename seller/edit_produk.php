<?php
session_start();
include '../configdb.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login.php");
    exit;
}

$seller_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id='$id' AND seller_id='$seller_id'");
    if (mysqli_num_rows($query) == 0) {
        die('Produk tidak ditemukan atau tidak memiliki akses.');
    }
    $produk = mysqli_fetch_assoc($query);
}

if (isset($_POST['update'])) {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = intval($_POST['harga']);
    $stock = intval($_POST['stock']);

    if (!empty($_FILES['foto']['name'])) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/$new_filename");
            $foto_url = "/uploads/$new_filename";
            mysqli_query($conn, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stock='$stock', foto_url='$foto_url' WHERE produk_id='$id' AND seller_id='$seller_id'");
        }
    } else {
        mysqli_query($conn, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stock='$stock' WHERE produk_id='$id' AND seller_id='$seller_id'");
    }
    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>`1
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

    <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
            <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']); ?>" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
            <input type="number" name="harga" value="<?= $produk['harga']; ?>" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
            <input type="number" name="stock" value="<?= $produk['stock']; ?>" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Produk (opsional)</label>
            <input type="file" name="foto" class="w-full border rounded py-2 px-3">
        </div>

        <div class="flex justify-between">
            <button type="submit" name="update" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Update</button>
            <a href="produk.php" class="text-yellow-600 hover:text-yellow-800">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
