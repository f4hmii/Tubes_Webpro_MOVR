
 <?php
$total_users = 7;
$total_barang = 14;
$pending_pembayaran = 0;

include '../db_connection.php';
$stmt = $pdo->query("SELECT COUNT(*) FROM pengguna");
if (!$stmt) {
    die("Query failed: " . $pdo->errorInfo()[2]);
}
$total_users = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM produk");
if (!$stmt) {
    die("Query failed: " . $pdo->errorInfo()[2]);
}
$total_barang = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM pembayaran WHERE status = 'pending'");
$pending_pembayaran = $stmt->fetchColumn();

?>

<h1>Dashboard</h1>

<div class="cards">
    <div class="card bg-red">
        <h3><span class="icon">👥</span>Total Users</h3>
        <p><?= $total_users ?></p>
    </div>
    <div class="card bg-red">
        <h3><span class="icon">🛒</span>Total Barang</h3>
        <p><?= $total_barang ?></p>
    </div>
    <div class="card bg-orange">
        <h3><span class="icon">⏳</span>Pembayaran Pending</h3>
        <p><?= $pending_pembayaran ?></p>
    </div>
</div>
