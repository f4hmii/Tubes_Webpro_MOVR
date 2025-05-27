<?php
include '../db_connection.php';
$id = $_GET['produk_id'];
$data = $conn->query("SELECT * FROM produk WHERE produk_id=$id")->fetch_assoc();
?>

<form method="POST" enctype="multipart/form-data">
    <!-- form input -->
</form>
<?php
if (isset($_POST['update'])) {
    // ...proses update...
    echo "<script>location='dashbord_admin.php#kelola_produk';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= $data['nama_produk'] ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"><?= $data['deskripsi'] ?></textarea>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" value="<?= $data['stock'] ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" value="<?= $data['harga'] ?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Gambar</label><br>
            <img src="../uploads/<?= $data['foto_url'] ?>" width="80"><br>
            <input type="file" name="gambar" class="form-control mt-2">
        </div>
        <button class="btn btn-primary" name="update">Update</button>
        <a href="../admincontrol/kelola_produk.php" class="btn btn-secondary">Kembali</a>
    </form>

<?php
if (isset($_POST['update'])) {
    $nama       = $_POST['nama'];
    $deskripsi  = $_POST['deskripsi'];
    $stok       = $_POST['stok'];
    $harga      = $_POST['harga'];

    if ($_FILES['gambar']['name']) {
        $foto_url = $_FILES['gambar']['name'];
        $tmp      = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/" . $foto_url);
    } else {
        $foto_url = $data['foto_url'];
    }

    $conn->query("UPDATE produk SET nama_produk='$nama', deskripsi='$deskripsi', stock=$stok, harga=$harga, foto_url='$foto_url' WHERE produk_id=$id");
    echo "<script>location='dashbord_admin.php#kelola_produk';</script>";
}
?>
</body>
</html>
