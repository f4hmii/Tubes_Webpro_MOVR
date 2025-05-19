<?php
session_start();
include "view/header.php";
include "db_connection.php";
?>

<html>

<head>
    <title>
        Detail
    </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"   />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }

    .hover-image img.second {
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
    }

    .hover-image:hover img.first {
        opacity: 0;
    }

    .hover-image:hover img.second {
        opacity: 1;
    }
</style>

<body class="bg-gray-100 text-gray-900">

    <main class="container mx-auto py-8 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <img alt="" class="w-full rounded-lg shadow-md" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                    <img alt="" class="w-full rounded-lg shadow-md" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img alt="" class="w-full rounded-lg shadow-md" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                    <img alt="" class="w-full rounded-lg shadow-md" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img alt="" class="w-full rounded-lg shadow-md" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                    <img alt="" class="w-full rounded-lg shadow-md" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                </div>
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-2">Dry Running T-shirt</h1>
                <p class="text-4xl font-bold text-red-600">Rp 128.124</p>
                <div class="flex items-center space-x-4 mb-4">

                    <button id="favoriteButton" class="p-2 rounded-full border hover:bg-red-100" title="Tambah ke Favorit">
                        <i id="favoriteIcon" class="far fa-heart text-black text-2xl"></i>
                    </button>

                    <a href="pages/chet.php" title="Chat" class="p-2 rounded-full border hover:bg-blue-100">
                        <i data-feather="message-circle" class="text-black"></i>
                    </a>

                    <a href="rating.php" class="flex items-center space-x-1 cursor-pointer">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="text-gray-600">(12 Review)</span>
                    </a>
                </div>

                <div class="mb-4">
                    <span class="text-gray-700">Colour:</span>
                    <div class="flex space-x-2 mt-2">
                        <div class="w-10 h-10 rounded-full border" style="background-color: blue;"></div>
                        <div class="w-10 h-10 rounded-full border" style="background-color: black;"></div>
                        <div class="w-10 h-10 rounded-full border" style="background-color: white;"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="text-gray-700">Size: <span id="selected-size"></span></span>
                    <div class="flex space-x-2 mt-2">
                        <button onclick="showSize('XS')"
                            class="border px-4 py-2 rounded-lg hover:bg-gray-200 disabled:opacity-50">XS</button>
                        <button onclick="showSize('S')"
                            class="border px-4 py-2 rounded-lg hover:bg-gray-200 ">S</button>
                        <button onclick="showSize('M')" class="border px-4 py-2 rounded-lg hover:bg-gray-200">M</button>
                        <button onclick="showSize('L')" class="border px-4 py-2 rounded-lg hover:bg-gray-200">L</button>
                        <button onclick="showSize('XL')"
                            class="border px-4 py-2 rounded-lg hover:bg-gray-200">XL</button>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Stock: <span id="stock">15</span></label>
                    <label for="quantity" class="block text-gray-700 mb-1">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="15" value="1"
                        class="w-24 border px-2 py-1 rounded-md" />
                </div>

                <form id="cart-form" action="cart.php" method="POST" class="hidden">
                    <input type="hidden" name="produk_id" value="1">
                    <input type="hidden" name="product_name" value="Dry Running T-shirt">
                    <input type="hidden" name="price" value="128124">
                    <input type="hidden" name="size" id="form-size">
                    <input type="hidden" name="quantity" id="form-quantity">
                </form>

                <button onclick="submitCart()" id="add-to-cart-btn" disabled class="mt-6 bg-black text-white px-6 py-3 w-full rounded-lg btn hover:bg-gray-800">
                    Add to cart
                </button>



                <button class="mt-2 border px-6 py-3 w-full rounded-lg btn hover:bg-gray-200">Find in store</button>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold">Dry Running T-shirt</h2>
                    <p class="text-gray-700">Our Latest Innovation in the world of running. Re-developed with dryfit
                        material that easily wicks away sweat. Dry Running T-shirt Ergonomically designed to conform to
                        the curves of the body, for a sleek feel that improves aerodynamics when racing.</p>
                    <ul class="mt-2 space-y-1 text-gray-700">
                        <li>Keeps You Cool</li>
                        <li>Keeps You Dry</li>
                        <li>Lightweight</li>
                        <li>Quick-Drying</li>
                        <li>Supportive</li>
                    </ul>
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold">Product details</h2>
                    <p class="text-gray-700">Model Measurements: Height: 165cm, Chest: 90cm, Waist: 72cm</p>
                    <p class="text-gray-700">Model wears Medium</p>
                </div>
                <div class="mt-4">
                    <h2 class="text-lg font-semibold">Delivery & returns</h2>
                    <p class="text-gray-700">Free delivery on orders over $120</p>
                </div>
            </div>
        </div>
        <div class="mt-8">

            <h2 class="text-xl font-semibold text-center">Customers Also Viewed</h2>
            <div class="grid lg:grid-cols-4 gap-4 mt-4">
                <a href="product1.html"
                    class="border p-4 hover-image rounded-lg shadow-md transform transition duration-500 hover:scale-105">
                    <div class="hover-image ">
                        <img alt="Product 1" class="first rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                        <img alt="Product 1 Hover" class="second rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_DV4855-570_d%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1080&q=75" />
                    </div>
                    <p class="mt-2 text-gray-700">Running suit</p>
                    <p class="text-red-600 font-semibold">Rp 700.000</p>
                </a>
                <a href="product2.html"
                    class="border p-4 hover-image rounded-lg shadow-md transform transition duration-500 hover:scale-105">
                    <div class="hover-image">
                        <img alt="Product 2" class="first rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IL8260_a%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1080&q=75" />
                        <img alt="Product 2 Hover" class="second rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_FB7352-010_c%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                    </div>
                    <p class="mt-2 text-gray-700">Shorts sport</p>
                    <p class="text-red-600 font-semibold">Rp 200.000</p>
                </a>
                <a href="product3.html"
                    class="border p-4 hover-image rounded-lg shadow-md transform transition duration-500 hover:scale-105">
                    <div class="hover-image">
                        <img alt="Product 3" class="first rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_FZ0767-410_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                        <img alt="Product 3 Hover" class="second rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_620138_c%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                    </div>
                    <p class="mt-2 text-gray-700">Sport suit</p>
                    <p class="text-red-600 font-semibold">Rp 250.000</p>
                </a>
                <a href="product4.html"
                    class="border p-4 hover-image rounded-lg shadow-md transform transition duration-500 hover:scale-105">
                    <div class="hover-image">
                        <img alt="Product 4" class="first rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_FN7690-070_a%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                        <img alt="Product 4 Hover" class="second rounded-lg" src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_MS41520-NNY_b%3Fw%3D700%26resmode%3Dsharp%26qlt%3D70%26fmt%3Dwebp&w=1920&q=75" />
                    </div>
                    <p class="mt-2 text-gray-700">Race Sunglasses</p>
                    <p class="text-red-600 font-semibold">Rp 800.000</p>
                </a>
            </div>
        </div>
    </main>

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
        function showSize(size) {
            document.getElementById('selected-size').innerText = size;
            document.getElementById('selected-size').dataset.value = size;
        }
    </script>

    <script>
        let selectedSize = null;

        function showSize(size) {
            selectedSize = size;
            document.getElementById('selected-size').innerText = size;
            document.getElementById('form-size').value = size;
            checkAddToCartButton();
        }

        document.getElementById('quantity').addEventListener('input', function() {
            document.getElementById('form-quantity').value = this.value;
            checkAddToCartButton();
        });

        function checkAddToCartButton() {
            const quantity = document.getElementById('quantity').value;
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            addToCartBtn.disabled = !(selectedSize && quantity > 0);
        }

        function submitCart() {
            const quantity = document.getElementById("quantity").value;
            document.getElementById("form-quantity").value = quantity;

            if (!selectedSize) {
                alert("Pilih ukuran terlebih dahulu.");
                return;
            }

            document.getElementById("cart-form").submit();
        }
    </script>




</body>

</html>