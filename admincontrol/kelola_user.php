<?php
include '../db_connection.php';

// Ambil data pengguna dari database
$result = mysqli_query($conn, "SELECT * FROM pengguna");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2 class="mb-4">Kelola User</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
             </thead>
<tbody>
<?php
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr class="<?= $row['status_aktif'] == 0 ? 'opacity-50' : '' ?>">
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['nama_pengguna']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['nomor_telepon']) ?></td>
        <td><?= htmlspecialchars($row['alamat']) ?></td>
        <td><?= htmlspecialchars($row['role']) ?></td>
        <td class="d-flex gap-2">
            <?php if ($row['status_aktif'] == 1): ?>
                <a href="edituser.php?pengguna_id=<?= $row['pengguna_id'] ?>" class="btn btn-sm btn-warning">
                    Edit
                </a>
                <a href="nonaktifkanUser.php?pengguna_id=<?= $row['pengguna_id'] ?>" class="btn btn-sm btn-secondary">
                    Nonaktifkan
                </a>
            <?php else: ?>
                <a class="btn btn-sm btn-warning disabled" tabindex="-1" aria-disabled="true" style="pointer-events: none;">
                    Edit
                </a>
                <a href="aktifkanUser.php?pengguna_id=<?= $row['pengguna_id'] ?>" class="btn btn-sm btn-success">
                    Aktifkan
                </a>
            <?php endif; ?>
        </td>
    </tr>
<?php
}
?>
</tbody>

