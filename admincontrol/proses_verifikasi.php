<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $id = (int) $_POST['id'];
    $action = $_POST['action'];

    if ($action === 'terima') {
        // Ambil data dari pengajuan
        $query = "SELECT * FROM pengajuan_produk WHERE pengajuan_produk_id = $id";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("Query gagal: " . mysqli_error($conn));
        }

        $data = mysqli_fetch_assoc($result);

        if ($data) {
            $nama = mysqli_real_escape_string($conn, $data['nama_produk']);
            $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
            $harga = (float) $data['harga'];
            $seller_id = (int) $data['seller_id'];
            $kategori_id = (int) $data['kategori_id']; // ✅ Tambahkan ini

            // ✅ Masukkan kategori_id dalam query insert
            $insert = "INSERT INTO produk (nama_produk, deskripsi, harga, seller_id, kategori_id)
                       VALUES ('$nama', '$deskripsi', '$harga', '$seller_id', '$kategori_id')";
            if (!mysqli_query($conn, $insert)) {
                die("Gagal insert produk: " . mysqli_error($conn));
            }
        }
    }

    // Hapus dari pengajuan
    $delete = "DELETE FROM pengajuan_produk WHERE pengajuan_produk_id = $id";
    if (!mysqli_query($conn, $delete)) {
        die("Gagal hapus: " . mysqli_error($conn));
    }

    mysqli_close($conn);
    header("Location: index.php");
    exit;
} else {
    echo "Data tidak lengkap atau metode request salah.";
}
?>