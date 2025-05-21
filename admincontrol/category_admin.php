<?php
include '../db_connection.php';

$sql = "SELECT produk.*, kategori.nama_kategori 
        FROM produk
        JOIN kategori ON produk.kategori_id = kategori.id_kategori
        ORDER BY produk.tanggal_input DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Produk</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>

<h2>Data Produk</h2>

<table>
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Gambar</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nama_produk']; ?></td>
                <td><?= $row['nama_kategori']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td><?= $row['tanggal_input']; ?></td>
                   <td><img src= "../uploads/<?= $row['foto_url']; ?>" width="100" height="100"></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">Tidak ada data produk</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
