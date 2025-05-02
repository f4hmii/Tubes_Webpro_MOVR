<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <style>
 
 * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  outline: none;
  border: none;
  text-decoration: none;
  font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}

body {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-image: url(https://plus.unsplash.com/premium_photo-1669021454094-fc77e12a38b7?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);
  background-size: cover;
  background-position: center;
  padding: 0;
 margin: 0;
}

.wrapper {
  width: 420px;
  background: transparent;
  border: 2px solid rgba(255, 255, 255, 0.2);
  backdrop-filter: blur(10px);
  box-shadow: 20 10 40px rgba(0, 0, 0, 0.459);
  color: #fff;
  padding: 30px 40px;
}
.wrapper h1 {
  font-size: 36px;
  text-align: center;
}
.wrapper .input-box {
  position: relative;
  width: 100%;
  height: 50px;
  margin: 30px 0;
}
.input-box input {
  width: 100%;
  height: 100%;
  background: transparent;
  border: none;
  outline: none;
  border: 2px solid rgba(255, 255, 255, 0.2);
  font-size: 16px;
  color: #fff;
  padding: 20px 45px 20px 20px;
}

.input-box-icon {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
  color: black;
}
.input-box input::placeholder {
  color: #fff;
}
.wrapper .remember-forgot {
  display: flex;
  justify-content: space-between;
  font-size: 14.5px;
  margin: -15px 0 15px;
}
.remember-forgot label input {
  accent-color: #fff;
  margin-right: 3px;
}
.remember-forgot a {
  color: #fff;
  text-decoration: none;
}
.remember-forgot a:hover {
  text-decoration: underline;
}
.wrapper .btn {
  width: 100%;
  height: 45px;
  background: #fff;
  border: none;
  outline: none;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  font-size: 16px;
  color: #333;
  font-weight: 600;
}
.wrapper .register-link {
  font-size: 14.5px;
  text-align: center;
  margin: 40px 0 8px;
}

.register-link p {
  margin-bottom: 20px; /* jarak antar p dan link "kembali" */
}

.register-link p a {
  color: red;
  text-decoration: none;
  font-weight: 600;
}

.register-link p a:hover {
  text-decoration: underline;
}

.register-link .back {
  color: black;
  text-decoration: none;
  font-weight: 600;
}

  </style>
<?php
session_start();

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "movr");

// Cek koneksi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Gunakan prepared statement
  $stmt = $conn->prepare("SELECT * FROM tb_user WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // Cek user ketemu?
  if ($result->num_rows === 1) {
      $user = $result->fetch_assoc();

      // Verifikasi password
      if (password_verify($password, $user['password'])) {
          $_SESSION['user_id'] = $user['id'];        // Simpan ID user
          $_SESSION['username'] = $user['username'];  // Simpan username
          $_SESSION['role'] = $user['role'];          // ❗❗ Simpan role juga (penting buat seller/admin)

          header("Location: /TA_WEBPRO/index.php");
          exit();
          
      } else {
          $error = "Password salah!";
      }
  } else {
      $error = "Username tidak ditemukan!";
  }

  $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css"> <!-- Pastikan file CSS ada -->
</head>
<body>
  <div class="wrapper">
    <form action="" method="POST">
      <h1>Login</h1>

      <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>

      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required />
        <div class="input-box-icon">
          <i data-feather="user"></i>
        </div>
      </div>

      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required />
        <div class="input-box-icon">
          <i data-feather="lock"></i>
        </div>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox" /> Remember Me</label>
        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="btn">Login</button>

      <div class="register-link">
        <p>Belum punya akun? <a href="register.php">Daftar</a></p>
        <a class="back" href="../index.php">kembali</a>
      </div>
    </form>
  </div>

  <script>
    feather.replace();
  </script>
</body>
</html>