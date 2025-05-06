<?php
include 'db_connection.php';

// Ambil input pencarian
$keyword = isset($_GET['q']) ? $koneksi->real_escape_string($_GET['q']) : '';

// Query pencarian
$sql = "SELECT * FROM produk WHERE nama LIKE '%$keyword%'";
$result = $koneksi->query($sql);

// Tampilkan hasil
if ($result->num_rows > 0) {
    echo "<h3>Hasil Pencarian:</h3>";
    while ($row = $result->fetch_assoc()) {
        echo "<p>{$row['nama']} - Rp " . number_format($row['harga']) . "</p>";
    }
} else {
    echo "Produk tidak ditemukan.";
}

$koneksi->close();
?>
