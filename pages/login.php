<?php
session_start();
include '../db_connection.php';

$error = "";

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses login jika form dikirim (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi!";
    } else {
        // Cek user aktif
        $stmt = $conn->prepare("SELECT * FROM pengguna WHERE username = ? AND status_aktif = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['sandi'])) {
                // Set session
                $_SESSION['id'] = $user['pengguna_id'];
                $_SESSION['pengguna_id'] = $user['pengguna_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header("Location: ../admincontrol/dashbord_admin.php");
                    exit();
                } elseif (in_array($user['role'], ['seller', 'buyer'])) {
                    header("Location: ../index.php");
                    exit();
                } else {
                    $error = "Role tidak dikenali!";
                }
            } else {
                $error = "Password salah!";
            }
        } else {
            // Cek apakah user nonaktif
            $stmt2 = $conn->prepare("SELECT * FROM pengguna WHERE username = ?");
            $stmt2->bind_param("s", $username);
            $stmt2->execute();
            $result2 = $stmt2->get_result();

            if ($result2 && $result2->num_rows === 1) {
                $user2 = $result2->fetch_assoc();
                if ($user2['status_aktif'] == 0) {
                    $error = "Akun Anda telah dinonaktifkan. Silakan hubungi admin.";
                } else {
                    $error = "Username tidak ditemukan!";
                }
            } else {
                $error = "Username tidak ditemukan!";
            }
            $stmt2->close();
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="min-h-screen flex items-start justify-center pt-32 bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
        <form class="space-y-6" action="" method="POST">
            <?php if (!empty($error)): ?>
                <p style="color:red;"><?= $error; ?></p>
            <?php endif; ?>
            <h5 class="text-xl font-medium text-gray-900 dark:text-white">Sign in to our platform</h5>

            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                <input type="text" name="username" id="username" placeholder="name@gmail.com"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                    dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                    dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
            </div>

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" type="checkbox"
                        class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 
                        focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 
                        dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                <a href="#" class="ms-auto text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a>
            </div>

            <button type="submit"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none 
                focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center 
                dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Login to your account
            </button>

            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                Not registered? 
                <a href="register.php" class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
