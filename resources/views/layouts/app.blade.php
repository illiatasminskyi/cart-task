<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Магазин')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-xl font-semibold text-gray-900">Магазин</a>
                </div>
                <div class="flex items-center space-x-4">
                    <button id="cart-button" class="relative bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors mr-2">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5H19M7 13l-1.1 5M7 13h10m0 0v8a2 2 0 002 2h-8a2 2 0 01-2-2v-8z"></path>
                            </svg>
                            Кошик
                            <span id="cart-count" class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-1">0</span>
                        </span>
                    </button>
                    @guest
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Вхід</a>
                    @endguest
                    @auth
                        <span class="text-gray-700 mr-4">Привіт, {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors border border-red-600 ml-2">Вихід</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Cart Modal -->
    <div id="cart-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full max-h-[80vh] overflow-y-auto">
                <div class="p-4 border-b">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Кошик</h3>
                        <button onclick="closeCart()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="cart-items" class="p-4">
                    <!-- Cart items will be inserted here -->
                </div>
                <div class="p-4 border-t">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold">Загалом:</span>
                        <span id="cart-total" class="text-lg font-bold text-blue-600">0 ₴</span>
                    </div>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">Оформити замовлення</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateCartCount() {
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = count;
        }

        function addToCart(id, name, price) {
            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    id,
                    name,
                    price,
                    quantity: 1
                });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            alert('Товар додано до кошика!');
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            renderCart();
        }

        function updateQuantity(id, newQuantity) {
            if (newQuantity <= 0) {
                removeFromCart(id);
                return;
            }
            const item = cart.find(item => item.id === id);
            if (item) {
                item.quantity = newQuantity;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                renderCart();
            }
        }

        function renderCart() {
            const cartItemsDiv = document.getElementById('cart-items');
            const cartTotalSpan = document.getElementById('cart-total');

            if (cart.length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-gray-500 text-center py-4">Кошик порожній</p>';
                cartTotalSpan.textContent = '0 ₴';
                return;
            }

            let html = '';
            let total = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;
                html += `
                    <div class="flex items-center justify-between py-2 border-b">
                        <div class="flex-1">
                            <h4 class="font-medium">${item.name}</h4>
                            <p class="text-sm text-gray-600">${item.price} ₴ x ${item.quantity}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm">-</button>
                            <span class="px-2">${item.quantity}</span>
                            <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm">+</button>
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 ml-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
            });

            cartItemsDiv.innerHTML = html;
            cartTotalSpan.textContent = total.toLocaleString() + ' ₴';
        }

        function openCart() {
            renderCart();
            document.getElementById('cart-modal').classList.remove('hidden');
        }

        function closeCart() {
            document.getElementById('cart-modal').classList.add('hidden');
        }

        document.getElementById('cart-button').addEventListener('click', openCart);

        // Initialize
        updateCartCount();
    </script>

    @fluxScripts
</body>

</html>