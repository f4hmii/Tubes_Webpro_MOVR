<?php
session_start();
include '../db_connection.php';
?>

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
        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                $kategori = $conn->query("SELECT * FROM kategori");
                while ($row = $kategori->fetch_assoc()) {
                    echo "<option value='{$row['kategori_id']}'>{$row['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Ukuran Produk</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" value="S"> <label class="form-check-label">S</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" value="M"> <label class="form-check-label">M</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" value="L"> <label class="form-check-label">L</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="size[]" value="XL"> <label class="form-check-label">XL</label>
            </div>
        </div>
        <div class="mb-3">
            <label>Warna</label>
            <input type="text" name="color" class="form-control" required>
        </div>

        <button class="btn btn-success" name="simpan">Simpan</button>
        <a href="produk.php" class="btn btn-secondary">Kembali</a>
    </form>

<?php
if (isset($_POST['simpan'])) {
   
    $nama        = htmlspecialchars($_POST['nama']);
    $deskripsi   = htmlspecialchars($_POST['deskripsi']);
    $stok        = intval($_POST['stok']);
    $harga       = floatval($_POST['harga']);
    $warna       = htmlspecialchars($_POST['color']);
    $kategori_id = intval($_POST['kategori_id']);
    $pengguna_id = intval($_SESSION['id']);
    $sizes       = isset($_POST['size']) ? $_POST['size'] : [];

    $gambar     = $_FILES['gambar']['name'];
    $tmp_name   = $_FILES['gambar']['tmp_name'];
    $upload_dir = "../uploads/";

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $file_ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    if (in_array($file_ext, $allowed_ext)) {
        // Tambahkan timestamp untuk nama file agar unik
        $new_filename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $gambar);
        move_uploaded_file($tmp_name, $upload_dir . $new_filename);

        $sql = "INSERT INTO produk (nama_produk, deskripsi, stock, harga, foto_url, seller_id, kategori_id, color) 
                VALUES ('$nama', '$deskripsi', $stok, $harga, '$new_filename', $pengguna_id, $kategori_id, '$warna')";

        if ($conn->query($sql)) {
            $produk_id = $conn->insert_id;

            // Simpan ukuran
            foreach ($sizes as $size) {
                $size = $conn->real_escape_string($size);
                $conn->query("INSERT INTO produk_size (produk_id, size) VALUES ($produk_id, '$size')");
            }

            echo "<script>location='produk.php';</script>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menyimpan produk: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Format file tidak diizinkan.</div>";
    }
}
?>

</body>
</html>
