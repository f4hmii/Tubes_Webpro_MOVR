<?php
session_start();
include '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login.php");
    exit;
}

$seller_id = $_SESSION['user_id'];

if (isset($_POST['tambah'])) {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = intval($_POST['harga']);
    $stock = intval($_POST['stock']);

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $path = "../uploads/" . $new_filename;
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $path)) {
                $foto_url = "/uploads/" . $new_filename;
                $query = mysqli_query($conn, "INSERT INTO produk (seller_id, nama_produk, harga, stock, deskripsi, foto_url) VALUES ('$seller_id', '$nama_produk', '$harga', '$stock', '$deskripsi', '$foto_url')");
                if ($query) {
                    echo "<script>alert('Produk berhasil ditambahkan!'); window.location='produk.php';</script>";
                } else {
                    echo "<script>alert('Gagal menambahkan produk ke database!');</script>";
                }
            } else {
                echo "<script>alert('Gagal upload gambar!');</script>";
            }
        } else {
            echo "<script>alert('Format gambar harus JPG atau PNG!');</script>";
        }
    } else {
        echo "<script>alert('Foto wajib diupload!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Tambah Produk</h1>

    <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
            <input type="text" name="nama_produk" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Produk</label>
            <textarea name="deskripsi" class="w-full border rounded py-2 px-3" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
            <input type="number" name="harga" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
            <input type="number" name="stock" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Foto Produk</label>
            <input type="file" name="foto" class="w-full border rounded py-2 px-3" required>
        </div>

        <div class="flex justify-between">
            <button type="submit" name="tambah" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Tambah Produk</button>
            <a href="produk.php" class="text-green-600 hover:text-green-800">Batal</a>
        </div>
    </form>
</div>

</body>
</html>
