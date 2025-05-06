<?php
session_start();
?>

<!-- Sidebar Cart -->
<div id="cartSidebar" class="fixed top-16 right-0 w-80 h-[calc(100vh-4rem)] bg-white shadow-lg transform translate-x-full transition-transform duration-300 z-40 overflow-y-auto">
    <div class="p-4 border-b flex justify-between items-center sticky top-0 bg-white z-10">
        <h2 class="text-lg font-semibold">Shopping Bag</h2>
        <button onclick="toggleCart()" class="text-gray-500 hover:text-black text-xl">&times;</button>
    </div>
    <div class="p-4 space-y-4" id="cartContent">
        <!-- Default cart content -->
        <div class="flex items-center space-x-4">
            <img src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700&fmt=webp&w=1920&q=75" class="w-16 h-16 object-cover rounded" alt="Product">
            <div>
                <p class="font-semibold">Dry Running T-shirt</p>
                <p class="text-sm text-gray-600">Size: M</p>
                <p class="text-sm text-gray-600">Qty: 1</p>
                <p class="text-red-600 font-bold">Rp 128.124</p>
            </div>
        </div>
        <div class="pt-4 border-t">
            <p class="flex justify-between font-bold">Subtotal: <span>Rp 128.124</span></p>
            <button class="mt-4 bg-black text-white w-full py-2 rounded hover:bg-gray-800">Checkout</button>
        </div>
    </div>
</div>

<script>
    function toggleCart() {
        const cart = document.getElementById('cartSidebar');
        cart.classList.toggle('translate-x-full');
    }

    // Pastikan navbar memiliki tinggi 16 (4rem) atau sesuaikan
    document.querySelector('.btn.bg-black').addEventListener('click', function() {
        const size = document.getElementById('selected-size').dataset.value || 'Not selected';
        const quantity = parseInt(document.getElementById('quantity').value);
        const stock = parseInt(document.getElementById('stock').innerText);
        const price = 128124;

        if (size === 'Not selected') {
            alert('Please select a size.');
            return;
        }

        if (quantity < 1 || quantity > stock) {
            alert('Invalid quantity.');
            return;
        }

        const total = quantity * price;

        document.getElementById('cartContent').innerHTML = `
        <div class="flex items-center space-x-4">
            <img src="https://jdsports.id/_next/image?url=https%3A%2F%2Fimages.jdsports.id%2Fi%2Fjpl%2Fjd_IS1657_b%3Fw%3D700&fmt=webp&w=1920&q=75" class="w-16 h-16 object-cover rounded" alt="Product">
            <div>
                <p class="font-semibold">Dry Running T-shirt</p>
                <p class="text-sm text-gray-600">Size: ${size}</p>
                <p class="text-sm text-gray-600">Qty: ${quantity}</p>
                <p class="text-red-600 font-bold">Rp ${total.toLocaleString('id-ID')}</p>
            </div>
        </div>
        <div class="pt-4 border-t">
            <p class="flex justify-between font-bold">Subtotal: <span>Rp ${total.toLocaleString('id-ID')}</span></p>
            <button class="mt-4 bg-black text-white w-full py-2 rounded hover:bg-gray-800">Checkout</button>
        </div>
        `;

        toggleCart();
    });
</script>