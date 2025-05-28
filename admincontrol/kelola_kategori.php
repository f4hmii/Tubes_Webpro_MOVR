<?php
include '../db_connection.php';

// Ambil semua produk beserta kategori
$query = "
    SELECT 
        p.produk_id, p.nama_produk, p.deskripsi, p.stock, p.harga, p.foto_url,
        k.nama_kategori
    FROM produk p
    LEFT JOIN kategori k ON p.kategori_id = k.kategori_id
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2 class="mb-4">Kelola Kategori Produk</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Deskripsi</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td><?= $row['stock'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['nama_kategori'] ?? '<em>Belum Ditentukan</em>' ?></td>
                <td><img src="../uploads/<?= $row['foto_url'] ?>" width="60" height="60"></td>
                <td>
                    <a href="edit_kategori_produk.php?produk_id=<?= $row['produk_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
