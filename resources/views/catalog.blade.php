@extends('layouts.app')

@section('title', 'Каталог товарів')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Каталог товарів</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
        <a href="{{ route('product.show', $product->id) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/300x200?text=Product' }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-blue-600">{{ number_format($product->price, 0, ',', ' ') }} ₴</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
@endsection