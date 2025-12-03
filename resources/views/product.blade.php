@extends('layouts.app')

@section('title', $product['name'])

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-96 object-cover">
            </div>
            <div class="md:w-1/2 p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product['name'] }}</h1>
                <p class="text-gray-600 mb-6">{{ $product['description'] }}</p>
                <div class="mb-6">
                    <span class="text-3xl font-bold text-blue-600">{{ number_format($product['price'], 0, ',', ' ') }} ₴</span>
                </div>
                <button onclick="addToCart({{ $product['id'] }}, '{{ addslashes($product['name']) }}', {{ $product['price'] }})" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors text-lg font-semibold">
                    Додати в кошик
                </button>
            </div>
        </div>
    </div>
@endsection