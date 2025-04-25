<?php
session_start();
include "view/header.php";
?>

<html>
 <head>
  <title>
   Web Page
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"   />
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
  }
    .content-section {
             background-image: url(/imgproduk3/sprinter.jpg);
              padding: 40px;
              text-align: left;
              height: 800px;
              border-bottom-left-radius: 60px;
          }
          
          .content-section h1 {
              margin-top: 210px;
              font-size: 36px;
              font-weight: bold;
          }
          .content-section p {
              font-size: 18px;
              margin-top: 2px;
              line-height: 1.4rem;
              max-width: 600px;
          }
          .main-content {
              padding: 40px;
          }
          .main-content h1 {
              font-size: 36px;
              font-weight: bold;
              text-align: center;
          }
          .main-content .image-text {
              display: flex;
              justify-content: space-between;
             
              
          }
          .main-content .image-text img {
              width: 100vw;
              height: 50vh;
             
          }
          .main-content .image-text .text {
              width: 48%;
              position: absolute;
          }
          .main-content .image-text .text p {
              font-size: 18px;
              position: absolute;
              max-width: 600px;
              padding: 50px;
              margin-top: 5rem;
              line-height: 1.4rem;
          }
       
          
  
  
  
  
  
          .main-content .image-text2 {
              display: flex;
              justify-content: space-between;
             margin-top: 2rem;
              padding: 15rem;
             
          }
          .main-content .image-text2 img {
              width: 600px;
              height: 400px;
              
          }
          .main-content .image-text2 .text2 {
              width: 48%;
          }
          .main-content .image-text2 .text2 p {
              font-size: 18px;
              line-height: 1.6rem;
          }
          .main-content .image-grid {
              display: flex;
              justify-content: space-between;
              flex-wrap: wrap;
              gap: 20px;
            margin-top: 3rem;
              margin-bottom: 3rem;
          }
          .main-content .image-grid img {
              width: 30vw;
              height: 20vh;
          }
  
  
  
          .main-content .image-grid2 {
              display: flex;
              justify-content: space-between;
              flex-wrap: wrap;
              gap: 1px;
              margin-top: 2rem;
          }
          .main-content .image-grid2 img {
              width: 17vw;
              
          }
          .main-content .image-grid2 .produkh2 {
              position: relative;
          }
          .produkh2 .judul{
              color: rgb(121, 120, 120);
              content: 'produk';
              position: absolute;
              bottom: 10px;
              left: 10px;
              font-size: 24px;
              font-weight: bold;
              
          }
         
          @media (max-width: 768px) {
              .navbar .nav-links {
                  flex-direction: column;
                  gap: 10px;
              }
              .main-content .image-text {
                  flex-direction: column;
              }
              .main-content .image-text img, .main-content .image-text .text {
                  width: 100%;
              }
              .main-content .image-grid img {
                  width: 100%;
              }
          }
  </style>
 </head>
 <body>
  

  <div class="content-section">
   <h1>
    MOVR SPORTSWEAR
   </h1>
   <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
   </p>
   <p>
    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
   </p>
  </div>
  <div class="main-content">
   <div class="image-text">
    <img alt="Sunset over mountains" height="400" src="/imgproduk/PROMO SERU MEMBER BARU.jpg" width="600"/>
    <div class="text">
     <p>
        kami percaya bahwa gerakan bukan hanya tentang olahraga, ini adalah gaya hidup. Terinspirasi oleh semangat untuk memberdayakan setiap individu dalam perjalanan kebugarannya, kami menciptakan sportswear yang menggabungkan performa, kenyamanan, dan gaya.
     </p>
    </div>
   </div>
   <div class="image-text2">
    <div class="text2">
     <p>
        Misi kami adalah menginspirasi setiap orang untuk bergerak dengan percaya diri, kekuatan, dan tujuan. Baik saat Anda menaklukkan gym, menjelajahi alam bebas, atau menemukan keseimbangan dalam yoga, MOVR dirancang untuk mendukung setiap momen dalam hidup aktif Anda.

        Setiap produk kami dibuat dengan penuh perhatian menggunakan bahan berkelanjutan dan teknologi inovatif. Kami mengutamakan daya tahan, sirkulasi udara, dan kenyamanan sempurna—semuanya sambil tetap berkomitmen melindungi lingkungan.
     </p>
     <p>
        Bergabunglah dengan komunitas MOVR dan ubah cara Anda bergerak. Bersama, kita akan mendefinisikan ulang arti gerakan yang penuh semangat dan tujuan.
     </p>
    </div>
    <img alt="" height="400" src="/imgproduk/tenis.jpg" width="600"/>
   </div>
   <h1>
    PROMO MENARIK
   </h1>
   <div class="image-grid">
    <img alt="" height="300" src="/VOUCHER/5.jpg" width="300"/>
    <img alt="" height="300" src="/VOUCHER/7.jpg" width="300"/>
    <img alt="" height="300" src="/VOUCHER/6.jpg" width="300"/>
   </div>
   <h1>
    PRODUK TERATAS
   </h1>
   <div class="image-grid2">
   <a href=""> <div class="produkh2">
        <h1 class="judul">Jersey MU</h1>
     <img alt="" height="300" src="https://www.adidas.co.id/media/catalog/product/cache/da73f7d26ad11f1980ada40c1f6e78fa/j/d/jd7147_3_apparel_on20model_standard20view_grey.jpg" width="300"/>
    </div></a>
    <a href=""><div class="produkh2">
        <h1 class="judul">Trail Running</h1>
     <img alt="" height="300" src="https://www.adidas.co.id/media/catalog/product/cache/da73f7d26ad11f1980ada40c1f6e78fa/i/h/ih6348_2_footwear_photography_side20lateral20view_grey.jpg" width="300"/>
    </div></a>
    <a href=""><div class="produkh2">
        <h1 class="judul">Jersey Black</h1>
     <img alt="" height="300" src="https://www.adidas.co.id/media/catalog/product/cache/da73f7d26ad11f1980ada40c1f6e78fa/j/n/jn7093_5_apparel_on20model_back20view_grey.jpg" width="300"/>
    </div></a>
    <a href=""><div class="produkh2">
        <h1 class="judul">T shirt</h1>
     <img alt="" height="300" src="https://www.adidas.co.id/media/catalog/product/cache/da73f7d26ad11f1980ada40c1f6e78fa/i/x/ix7442_5_apparel_on20model_back20view_grey.jpg" width="300"/>
    </div></a>
    <a href=""><div class="produkh2">
        <h1 class="judul">Kid Soes</h1>
     <img alt="" height="300" src="https://www.adidas.co.id/media/catalog/product/cache/a2326ed7dcde4da57fee4197e095ea73/i/e/ie6534_2_footwear_photography_side_lateral_view_grey.jpeg" width="300"/>
    </div></a>
   </div>
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
 </body>
</html>
