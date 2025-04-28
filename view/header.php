<head>
  <title>
    Web Page
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"   />
  <link rel="stylesheet" href="home4.css">

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
      background-color: rgb(255, 255, 255);
      color: #000000;
      padding: 0;
      margin: 0;
      max-width: 100vw;

    }

    .navbar {
      display: flex;
      justify-content: space-between;
      padding: 30px 40px;
      position: sticky;
      z-index: 999999;
      width: 100%;
      height: 60px;
      top: 0;
      box-shadow: 0 2px 5px rgb(31, 30, 30);
      align-items: center;
      background-color: #ffffff;

    }

    .navbar .logo h1 {
      color: #000000;
      font-size: 1.3rem;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 30px;
      align-items: center;
      margin-left: 0;
    }

    .navbar ul li {
      position: relative;
    }

    .navbar ul li a {
      text-decoration: none;
      color: #000000;
      font-size: 16px;
      display: flex;
      position: relative;
    }

    .navbar ul li a:hover {
      color: #979696;
    }

    .navbar ul li a::after {
      content: "";
      display: block;
      width: 100%;
      transform: scaleX(0);
      transition: transform 0.5s inherit;
      position: absolute;
      bottom: 0;
      border-bottom: 2px solid #fff;
      transition: transform 0.5s ease;
    }

    .navbar ul li a:hover::after {
      transform: scaleX(0.5);
      transition: transform 0.3s linear;
    }

    .navbar .search a {

      color: #000000;

      padding: 2px 8px;

    }

    .navbar .search a:hover {
      color: #979696;
    }

    .navbar .icon-wrapper {
      color: #000;
      display: flex;
      align-items: center;
      text-decoration: none;
      gap: 20px;
    }

    .navbar .icon-wrapper .user {
      color: #000;
      display: flex;
      align-items: center;
      flex-direction: column;
    }

    .user-dropdown {
      position: relative;
    }

    .user-dropdown-toggle {
      display: flex;
      align-items: center;
      cursor: pointer;
      color: #000;
    }

    .user-dropdown-menu {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 9999;
      width: 180px;
    }

    .user-dropdown-menu a {
      display: block;
      padding: 10px 15px;
      color: #000;
      text-decoration: none;
    }

    .user-dropdown-menu a:hover {
      background-color: #f0f0f0;
    }

    .category-dropdown {
      position: relative;
    }

    .category-dropdown-toggle {
      cursor: pointer;
    }

    .category-dropdown-menu {
      display: none;
      position: absolute;
      top: 40px;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      z-index: 9999;
      width: 180px;
    }

    .category-dropdown-menu a {
      display: block;
      padding: 10px 15px;
      color: #000;
      text-decoration: none;
    }

    .category-dropdown-menu a:hover {
      background-color: #f0f0f0;
    }
  </style>


<body>
  <div class="navbar">
    <div class="logo">
      <h1>MOVR</h1>
    </div>

    <ul>
  <li><a href="#">Home</a></li>
  <li><a href="aboutfairuz.html">About</a></li>
  <li><a href="#produk">Produk</a></li>
  <li><a href="announcement.html">Announcement</a></li>
  <li><a href="servicefairuz.html">Service</a></li>
  

      <!-- Category Toggle Dropdown -->
      <?php
      // Daftar kategori (nanti bisa diambil dari database juga)
      $kategori = [
        'Baju' => 'view/kategori.php?kategori=baju',
        'Celana' => 'view/kategori.php?kategori=celana',
        'Sepatu' => 'view/kategori.php?kategori=sepatu',
        'Aksesoris' => 'view/kategori.php?kategori=aksesoris'
      ];
      ?>

      <li class="category-dropdown">
        <div class="category-dropdown-toggle" onclick="toggleCategoryDropdown()">
          <a href="#">Category</a>
        </div>
        <div class="category-dropdown-menu" id="categoryDropdown">
          <?php foreach ($kategori as $nama => $link): ?>
            <a href="<?php echo $link; ?>"><?php echo htmlspecialchars($nama); ?></a>
          <?php endforeach; ?>
        </div>
      </li>
      <li><a href="sale.php">Sale</a></li>
    </ul>


    <div class="icon-wrapper">
      <a href="favorit.php" title="Favorit" style="margin-right: 10px;">
        <i data-feather="heart"></i>
      </a>

      <a href="keranjang.php" title="Keranjang" style="margin-right: 10px;">
        <i data-feather="shopping-cart"></i>
      </a>

      <?php if (isset($_SESSION['username'])): ?>
        <div class="user-dropdown">
          <div class="user-dropdown-toggle" onclick="toggleUserDropdown()">
            <i data-feather="user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
          </div>
          <div class="user-dropdown-menu" id="userDropdown">
            <a href="profil.php">Informasi Akun</a>
            <a href="#" onclick="confirmLogout()">Logout</a>
          </div>
        </div>
      <?php else: ?>
        <a href="pages/login.php">
          <i data-feather="log-in"></i>
        </a>
      <?php endif; ?>
    </div>



  </div>

  <script>
    feather.replace(); // Aktifkan semua ikon feather
  </script>
  <script>
    function toggleUserDropdown() {
      const dropdown = document.getElementById("userDropdown");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    // Optional: Klik di luar menutup dropdown
    window.addEventListener("click", function(e) {
      const toggle = document.querySelector(".user-dropdown-toggle");
      const menu = document.getElementById("userDropdown");

      if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.style.display = "none";
      }
    });
  </script>
  <script>
    function toggleCategoryDropdown() {
      const dropdown = document.getElementById("categoryDropdown");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    window.addEventListener("click", function(e) {
      const toggle = document.querySelector(".category-dropdown-toggle");
      const menu = document.getElementById("categoryDropdown");

      if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.style.display = "none";
      }
    });
  </script>
  <script>
    function confirmLogout() {
      const yakin = confirm("Apakah Anda yakin ingin logout?");
      if (yakin) {
        window.location.href = "pages/logout.php"; // Redirect ke logout.php kalau user klik "OK"
      }
    }
  </script>

</body>