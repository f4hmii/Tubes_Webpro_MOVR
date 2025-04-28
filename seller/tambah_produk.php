<?php
session_start();
include '../configdb.php';

// Cek apakah seller sudah login
if (!isset($_SESSION['seller_id'])) {
    header("Location: ../login.php");
    exit;
}

$seller_id = $_SESSION['seller_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tambah Produk</h1>

    <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
            <input type="text" name="nama_produk" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
            <input type="number" name="harga" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
            <input type="number" name="stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Produk</label>
            <input type="file" name="foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" name="tambah" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Tambah Produk
            </button>
            <a href="produk.php" class="inline-block align-baseline font-bold text-sm text-green-500 hover:text-green-800">
                Batal
            </a>
        </div>
    </form>

    <?php
    if (isset($_POST['tambah'])) {
        $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
        $harga = intval($_POST['harga']);
        $stock = intval($_POST['stock']);

        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];
        $path = "../uploads/" . $foto;

        if (move_uploaded_file($tmp, $path)) {
            $query = mysqli_query($conn, "INSERT INTO produk (seller_id, nama_produk, harga, stock, foto_url) VALUES ('$seller_id', '$nama_produk', '$harga', '$stock', '/uploads/$foto')");
            if ($query) {
                echo "<script>alert('Produk berhasil ditambahkan!'); window.location='produk.php';</script>";
            } else {
                echo "<script>alert('Gagal menambahkan produk!');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengupload gambar!');</script>";
        }
    }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>
