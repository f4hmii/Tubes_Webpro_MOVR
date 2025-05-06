<?php
session_start();
include "view/header.php";
?>

<?php
include 'db_connection.php';

// Ambil data dari tabel produk
$query = "SELECT * FROM produk";
$result = $conn->query($query);

// Simpan hasil query ke array $products
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>

<html>

<head>
  <title>
    Web Page
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"   />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> 
    <script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="index.css">

 </head>
 <body>
  

<body>


  <div class="carousel">
    <button class="carousel-btn prev-btn fa-solid fa-chevron-left">
      <!-- <i class="fa-solid fa-chevron-left"></i> -->
    </button>
    <div class="carousel-slides">

      <div class="slide">
        <img src="https://www.newbalance.co.id/media/weltpixel/owlcarouselslider/images/s/e/secondary_banner_desktop_2400_x_900-20241220-065408.jpg"
          alt="">
      </div>
      <div class="slide">
        <img src="https://www.newbalance.co.id/media/weltpixel/owlcarouselslider/images/s/e/secondary_banner-20240805-072521.jpg"
          alt="">
      </div>
      <div class="slide">
        <img src="https://www.newbalance.co.id/media/weltpixel/owlcarouselslider/images/s/e/secondary_banner_copy-20241118-093422.jpg"
          alt="">
      </div>
      <div class="slide">
        <img src="https://i.pinimg.com/736x/d5/cf/48/d5cf48081afa823efe25b2275446725b.jpg" alt="">
      </div>

    </div>
    <button class="carousel-btn next-btn fa-solid fa-chevron-right">

    </button>
  </div>

  <header>
    <h1>Fashion Sale Collection</h1>
  </header>
  <br>
    <div class="container">
    <?php foreach ($products as $product): ?>
    <div class="card">
    <img src="uploads/<?= $product['foto_url'] ?>" alt="product image" width="150px">
        <i class="fa-regular fa-heart"></i>
        <div class="card-content">
            <p class="title"><?= $product['nama_produk'] ?></p>
            <p class="price">Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>
            <p class="description"><?= $product['deskripsi'] ?></p>
        </div>
    </div>
    <?php endforeach; ?>
</div>

  <footer class="bg-gray-800 text-white mt-12">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="py-8">
        <h3 class="text-lg font-semibold mb-4">About Us</h3>
        <p class="text-gray-400">We are a leading sportswear brand committed to providing high-quality
          products
          for athletes and fitness enthusiasts.</p>
        <div class="mt-4">
          <a class="text-gray-400 hover:text-white" href="#"><i class="fab fa-facebook-f"></i></a>
          <a class="ml-4 text-gray-400 hover:text-white" href="#"><i class="fab fa-twitter"></i></a>
          <a class="ml-4 text-gray-400 hover:text-white" href="#"><i class="fab fa-instagram"></i></a>
          <a class="ml-4 text-gray-400 hover:text-white" href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
      <div class="py-8">
        <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
        <ul class="text-gray-400">
          <li class="mb-2"><a class="hover:text-white" href="#">Contact Us</a></li>
          <li class="mb-2"><a class="hover:text-white" href="#">Order Tracking</a></li>
          <li class="mb-2"><a class="hover:text-white" href="#">Returns & Exchanges</a></li>
          <li class="mb-2"><a class="hover:text-white" href="#">Shipping & Delivery</a></li>
          <li class="mb-2"><a class="hover:text-white" href="#">FAQs</a></li>
        </ul>
      </div>
      <div class="py-8">
        <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
        <p class="text-gray-400">Subscribe to get the latest information on new products and upcoming sales.
        </p>
        <form class="mt-4">
          <input class="w-full p-2 rounded-lg text-gray-900" placeholder="Enter your email" type="email" />
          <button class="mt-2 w-full bg-red-600 p-2 rounded-lg hover:bg-red-700"
            type="submit">Subscribe</button>
        </form>
      </div>
      <div class="mt-8 text-center text-gray-400">
        <p>© 2023 Movr. All rights reserved.</p>
      </div>
  </footer>
  <script>
    feather.replace();
  </script>
  <script>
    const carouselSlides = document.querySelector('.carousel-slides');
    const slides = document.querySelectorAll('.slide');
    const slide = document.querySelectorAll('.slides');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    let currentIndex = 0;

    // Function to update carousel position
    function updateCarousel() {
      const offset = -currentIndex * 100;
      carouselSlides.style.transform = `translateX(${offset}%)`;
    }

    // Go to the previous slide
    prevBtn.addEventListener('click', () => {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateCarousel();
      resetAutoSlide();
    });


    // Go to the next slide
    nextBtn.addEventListener('click', () => {
      currentIndex = (currentIndex + 1) % slides.length;
      updateCarousel();
      resetAutoSlide();
    });


    function startAutoSlide() {
      autoSlideInterval = setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        updateCarousel();
      }, 3000);
    }

    function resetAutoSlide() {
      clearInterval(autoSlideInterval);
      startAutoSlide();
    }

    startAutoSlide();
  </script>
</body>

</html>