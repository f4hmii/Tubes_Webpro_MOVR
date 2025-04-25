
<?php
session_start(); // Mulai session

// Hapus semua data session
$_SESSION = [];
session_unset();
session_destroy();

// Redirect ke halaman login (atau ubah ke halaman lain jika perlu)
header("Location: pages/login.php");
exit;
?>
