<?php
session_start();
include '../configdb.php';

// Cek apakah seller sudah login
if (!isset($_SESSION['seller_id'])) {
    header("Location: ../login.php");
    exit;
}

$seller_id = $_SESSION['seller_id'];

// Proses Hapus Produk
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Cek apakah produk milik seller ini
    $cek = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id='$id' AND seller_id='$seller_id'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "DELETE FROM produk WHERE produk_id='$id'");
        header("Location: produk.php?msg=deleted");
    } else {
        echo "<script>alert('Produk tidak ditemukan atau Anda tidak memiliki akses!'); window.location='produk.php';</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

    <?php
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id='$id' AND seller_id='$seller_id'");
        if (mysqli_num_rows($query) > 0) {
            $produk = mysqli_fetch_assoc($query);
    ?>

    <form action="edit_produk.php" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <input type="hidden" name="produk_id" value="<?= $produk['produk_id']; ?>">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
            <input name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
            <input type="number" name="harga" value="<?= $produk['harga']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
            <input type="number" name="stock" value="<?= $produk['stock']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto (Opsional)</label>
            <input type="file" name="foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" name="update" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Produk
            </button>
            <a href="produk.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Batal
            </a>
        </div>
    </form>

    <?php
        } else {
            echo "<p>Produk tidak ditemukan!</p>";
        }
    }

    // Proses Update Produk
    if (isset($_POST['update'])) {
        $id = intval($_POST['produk_id']);
        $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
        $harga = intval($_POST['harga']);
        $stock = intval($_POST['stock']);

        if (!empty($_FILES['foto']['name'])) {
            $foto = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($tmp, "../uploads/$foto");
            mysqli_query($conn, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stock='$stock', foto_url='/uploads/$foto' WHERE produk_id='$id' AND seller_id='$seller_id'");
        } else {
            mysqli_query($conn, "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stock='$stock' WHERE produk_id='$id' AND seller_id='$seller_id'");
        }

        header("Location: produk.php?msg=updated");
        exit;
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>
