<?php
session_start();
include '../configdb.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: ../login.php");
    exit;
}

$seller_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id='$id' AND seller_id='$seller_id'");
    if (mysqli_num_rows($query) > 0) {
        mysqli_query($conn, "DELETE FROM produk WHERE produk_id='$id'");
    }
}
header("Location: produk.php");
exit;
?>
