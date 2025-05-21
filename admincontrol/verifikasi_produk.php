<?php
 include '../db_connection.php';
 ?>

<h2>Verifikasi Produk Seller</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama Produk</th>
        <th>Deskripsi</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>

    <?php
    $query = "SELECT * FROM pengajuan_produk";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nama_produk']) . "</td>";
        echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['harga']) . "</td>";
        echo "<td>
                <form method='post' action='proses_verifikasi.php' style='display:inline;'>
                    <input type='hidden' name='id' value='{$row['pengajuan_produk_id']}'>
                    <button type='submit' name='action' value='terima'>Terima</button>
                    <button type='submit' name='action' value='tolak' onclick='return confirm(\"Yakin tolak produk ini?\")'>Tolak</button>
                </form>
              </td>";
        echo "</tr>";
    }

    mysqli_close($conn);
    ?>
</table>
