@extends('layouts.app')

@section('title', 'Каталог товарів')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Каталог товарів</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
            ['id' => 1, 'name' => 'Ноутбук Lenovo ThinkPad', 'description' => 'Потужний ноутбук для роботи та ігор.', 'price' => 25000, 'image' => 'https://via.placeholder.com/300x200?text=Laptop'],
            ['id' => 2, 'name' => 'Смартфон Samsung Galaxy', 'description' => 'Сучасний смартфон з великим екраном.', 'price' => 15000, 'image' => 'https://via.placeholder.com/300x200?text=Phone'],
            ['id' => 3, 'name' => 'Навушники Sony', 'description' => 'Бездротові навушники з шумозаглушенням.', 'price' => 3000, 'image' => 'https://via.placeholder.com/300x200?text=Headphones'],
            ['id' => 4, 'name' => 'Миша Logitech', 'description' => 'Ергономічна миша для комп\'ютера.', 'price' => 500, 'image' => 'https://via.placeholder.com/300x200?text=Mouse'],
            ['id' => 5, 'name' => 'Клавіатура Mechanical', 'description' => 'Механічна клавіатура з підсвіткою.', 'price' => 2000, 'image' => 'https://via.placeholder.com/300x200?text=Keyboard'],
        ] as $product)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product['name'] }}</h3>
                <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($product['description'], 100) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-blue-600">{{ number_format($product['price'], 0, ',', ' ') }} ₴</span>
                    <div class="space-x-2">
                        <a href="{{ route('product.show', $product['id']) }}" class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 transition-colors">Переглянути</a>
                        <button onclick="addToCart({{ $product['id'] }}, '{{ addslashes($product['name']) }}', {{ $product['price'] }})" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition-colors">В кошик</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection