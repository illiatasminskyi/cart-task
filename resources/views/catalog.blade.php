@extends('layouts.app')

@section('title', 'Каталог товарів')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Каталог товарів</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
        <div class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
            <a href="{{ route('product.show', $product->id) }}">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/300x200?text=Product' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            </a>
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-blue-600">{{ number_format($product->price, 0, ',', ' ') }} ₴</span>
                    <form method="POST" action="{{ route('cart.add') }}" class="ml-2 flex items-center space-x-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">В кошик</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection