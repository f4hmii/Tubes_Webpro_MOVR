<?php include '../configdb.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2>Tambah Produk</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>ID Produk</label>
            <input type="number" name="produk_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control" required>
        </div>
        <button class="btn btn-success" name="simpan">Simpan</button>
        <a href="produk.php" class="btn btn-secondary">Kembali</a>
    </form>

<?php
if (isset($_POST['simpan'])) {
    // Ambil data form
    $produk_id  = intval($_POST['produk_id']);
    $nama       = htmlspecialchars($_POST['nama']);
    $deskripsi  = htmlspecialchars($_POST['deskripsi']);
    $stok       = intval($_POST['stok']);
    $harga      = floatval($_POST['harga']);
    
    // Upload file
    $gambar     = $_FILES['gambar']['name'];
    $tmp_name   = $_FILES['gambar']['tmp_name'];
    $upload_dir = "../uploads/";

    // Validasi ekstensi file (opsional)
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
    
    if (in_array($file_ext, $allowed_ext)) {
        move_uploaded_file($tmp_name, $upload_dir . $gambar);

        // Simpan ke DB
        $sql = "INSERT INTO produk (produk_id, nama_produk, deskripsi, stock, harga, foto_url) 
                VALUES ($produk_id, '$nama', '$deskripsi', $stok, $harga, '$gambar')";
        if ($conn->query($sql)) {
            echo "<script>location='produk.php';</script>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menyimpan: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Format file tidak diizinkan. Gunakan JPG, PNG, atau GIF.</div>";
    }
}
?>
</body>
</html>
