<?php
// filepath: c:\xampp\htdocs\Tubes_Webpro_MOVR\admincontrol\hapusUser.php
    include '../db_connection.php';
    if (isset($_GET['pengguna_id']) && is_numeric($_GET['pengguna_id'])) {
        $id = intval($_GET['pengguna_id']);

        $stmt = $conn->prepare("UPDATE pengguna SET status_aktif = 0 WHERE pengguna_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: dashbord_admin.php#kelola_user");
            exit();
        } else {
            echo "Gagal menonaktifkan user. Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID user tidak ditemukan atau tidak valid.";
    }
?>