<?php
include '../db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keranjang_id'])) {
    $keranjang_id = intval($_POST['keranjang_id']);
    $stmt = $conn->prepare("DELETE FROM keranjang WHERE keranjang_id = ?");
    $stmt->bind_param("i", $keranjang_id);
    $stmt->execute();
}

header("Location: cart/cart.php");
exit;
