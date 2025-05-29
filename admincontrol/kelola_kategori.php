<?php
// Koneksi ke database
include '../db_connection.php';

// Handle pesan
$pesan = '';
if (isset($_GET['status']) && $_GET['status'] === 'sukses' && isset($_GET['nama'])) {
    $nama = htmlspecialchars($_GET['nama']);
    $pesan = "<div class='alert alert-success mb-2'>Kategori <b>$nama</b> berhasil ditambah!</div>";
}

// Handle tambah kategori
if (isset($_POST['tambah_kategori'])) {
    $nama_kategori = trim($_POST['nama_kategori']);

    if (!empty($nama_kategori)) {
        // Cek apakah kategori sudah ada
        $cek = $conn->prepare("SELECT 1 FROM kategori WHERE nama_kategori = ?");
        $cek->bind_param("s", $nama_kategori);
        $cek->execute();
        $cek->store_result();

        if ($cek->num_rows > 0) {
            $pesan = "<div class='alert alert-warning mb-2'>Kategori <b>$nama_kategori</b> sudah ada!</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
            $stmt->bind_param("s", $nama_kategori);
        if ($stmt->execute()) {
            $pesan = "<div class='alert alert-success mb-2'>Kategori <b>$nama_kategori</b> berhasil ditambah!</div>";
            // Tidak ada header redirect!
            } else {
                $pesan = "<div class='alert alert-danger mb-2'>Gagal menambah kategori: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $cek->close();
    }
}


// Ambil semua kategori dan jumlah produk
$kategoriList = $conn->query("
    SELECT k.kategori_id, k.nama_kategori, COUNT(p.produk_id) AS jumlah_produk
    FROM kategori k
    LEFT JOIN produk p ON k.kategori_id = p.kategori_id
    GROUP BY k.kategori_id
");

// Ambil semua produk
$produkResult = $conn->query("
    SELECT 
        p.produk_id, p.nama_produk, p.deskripsi, p.stock, p.harga, p.foto_url,
        k.nama_kategori
    FROM produk p
    LEFT JOIN kategori k ON p.kategori_id = k.kategori_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Kategori Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

    <h2 class="mb-4">Kelola Kategori Produk</h2>

    <!-- Tampilkan pesan -->
    <?php if ($pesan) echo $pesan; ?>

    <!-- Form Tambah Kategori -->
    <form method="POST" action="kelola_kategori.php" class="mb-4 d-flex gap-2">
        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
        <button type="submit" name="tambah_kategori" class="btn btn-success">Tambah Kategori</button>
    </form>

    <!-- Daftar Kategori -->
    <div class="mb-4">
        <h5>Daftar Kategori</h5>
        <ul class="list-group">
        <?php while ($kategori = $kategoriList->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><?= htmlspecialchars($kategori['nama_kategori']) ?></span>
                <span>
                    <a href="hapusKategori.php?kategori_id=<?= $kategori['kategori_id'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                    <span class="badge bg-primary rounded-pill ms-2"><?= $kategori['jumlah_produk'] ?> produk</span>
                </span>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>

    <!-- Daftar Produk -->
    <h5 class="mb-3">Daftar Produk</h5>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
            <?php while ($row = $produkResult->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><?= $row['stock'] ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td><?= $row['nama_kategori'] ?? '<em>Belum Ditentukan</em>' ?></td>
                    <td>
                        <?php if ($row['foto_url']): ?>
                            <img src="../uploads/<?= $row['foto_url'] ?>" width="60" height="60" style="object-fit:cover;">
                        <?php else: ?>
                            <span class="text-muted">Tidak Ada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_kategori_produk.php?produk_id=<?= $row['produk_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Hapus query string dari URL agar pesan tidak muncul lagi saat refresh -->
    <script>
        if (window.location.search.includes('status=')) {
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>

</body>
</html>
