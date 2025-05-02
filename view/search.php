<?php
include 'db_connection.php'; // Koneksi database

// Ambil kata kunci pencarian
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

// Query untuk mencari produk berdasarkan kata kunci
$stmt = $conn->prepare("SELECT * FROM produk WHERE nama_produk LIKE ?");
$searchTerm = "%$query%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Tampilkan hasil pencarian
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Hasil Pencarian untuk "<?php echo htmlspecialchars($query); ?>"</h1>
    <div class="product-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product">
                <img src="<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_produk']); ?>">
                <h2><?php echo htmlspecialchars($row['nama_produk']); ?></h2>
                <p><?php echo htmlspecialchars($row['harga']); ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <style>
        .search-form {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
}
.search-form {
    display: flex;
    justify-content: center;
    margin: 20px 0;
}

.search-box {
    position: relative;
    width: 400px;
}

.search-box input[type="text"] {
    width: 100%;
    padding: 10px 15px 10px 40px;
    border: 1px solid #ccc;
    border-radius: 25px;
    background-color: #f9f9f9; /* Warna latar belakang */
    color: #333; /* Warna teks */
    font-size: 16px;
    outline: none;
    transition: all 0.3s ease;
}

/* .search-box input[type="text"]::placeholder {
    background color:rgb(35, 28, 28)/* Warna placeholder */
} */

.search-box input[type="text"]:focus {
    border-color: #007bff; /* Warna border saat fokus */
    background-color: #fff; /* Warna latar belakang saat fokus */
}

.search-box i {
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    color: #aaa; /* Warna ikon */
    font-size: 18px;
}
.product-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.product {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
}

.product img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

.product h2 {
    font-size: 18px;
    margin: 10px 0;
}

.product p {
    color: #007bff;
    font-weight: bold;
}
        </style>
</body>
</html>