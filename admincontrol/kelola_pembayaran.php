<?php
include '../db_connection.php';

// Proses update status (GET)
if (isset($_GET['update_status'])) {
    $id = intval($_GET['pembayaran_id']);
    $status = $_GET['status_pembayaran'];

    $allowed_status = ['pending', 'confirmed', 'rejected'];
    if (!in_array($status, $allowed_status)) {
        die("Status tidak valid!");
    }

    $stmt = $conn->prepare("UPDATE pembayaran SET status_pembayaran=? WHERE pembayaran_id=?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $id);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();

    // Setelah update, reload halaman (opsional, tapi GET sudah otomatis reload)
   header("Location: dashbord_admin.php#kelola_pembayaran");
exit;
}

// Ambil data pembayaran
$result = $conn->query("SELECT 
                pembayaran.pembayaran_id,
                pengguna.nama_pengguna, 
                pembayaran.jumlah_pembayaran, 
                metode_pembayaran.nama_bank, 
                metode_pembayaran.metode,
                pembayaran.bukti_pembayaran,
                pembayaran.tanggal_pembayaran,
                pembayaran.status_pembayaran
                FROM `pembayaran`
                INNER JOIN transaksi ON pembayaran.pesanan_id = transaksi.transaksi_id
                INNER JOIN pengguna ON transaksi.pengguna_id = pengguna.pengguna_id
                INNER JOIN metode_pembayaran ON pembayaran.metode_pembayaran = metode_pembayaran.id 
                ORDER BY tanggal_pembayaran DESC");
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Kelola Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-5">
    <h2 class="mb-4">Kelola Pembayaran</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Pembeli</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Bukti Pembayaran</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    $bukti_pembayaran = base64_encode($row['bukti_pembayaran']);
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_pengguna']) ?></td>
                        <td>Rp <?= number_format($row['jumlah_pembayaran'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['nama_bank']) . ' - ' . htmlspecialchars($row['metode']) ?></td>
        
                        <td>
                            <?php if (!empty($row['bukti_pembayaran'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($row['bukti_pembayaran']); ?>" width="100" height="100" class="img-thumbnail" />
                            <?php else: ?>
                                <span class="text-muted">Tidak Ada</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['tanggal_pembayaran']) ?></td>
                        <td>
                           <span class="badge bg-<?= 
                                $row['status_pembayaran'] == 'confirmed' ? 'success' : 
                                ($row['status_pembayaran'] == 'rejected' ? 'danger' : 'secondary') ?>">
                                <?= htmlspecialchars(ucfirst($row['status_pembayaran'])) ?>
                            </span>
                        </td>
                        <td>
                           <form method="get" action="kelola_pembayaran.php" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="update_status" value="1" />
                            <input type="hidden" name="pembayaran_id" value="<?= intval($row['pembayaran_id']) ?>" />
                            <select name="status_pembayaran" class="form-select form-select-sm" required>
                                <option value="confirmed" <?= $row['status_pembayaran'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="rejected" <?= $row['status_pembayaran'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary" <?= strtolower($row['status_pembayaran']) !== 'pending' ? 'disabled' : '' ?>>Update</button>
                        </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>