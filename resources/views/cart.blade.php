@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Ваша корзина</h2>
    <div>
        @if($cartItems->isEmpty())
            <p class="text-gray-600">Корзина порожня.</p>
        @else
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4">Товар</th>
                        <th class="py-2 px-4">Кількість</th>
                        <th class="py-2 px-4">Ціна</th>
                        <th class="py-2 px-4">Сума</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="py-2 px-4">{{ $item->product->name }}</td>
                        <td class="py-2 px-4">{{ $item->quantity }}</td>
                        <td class="py-2 px-4">{{ number_format($item->product->price, 0, ',', ' ') }} ₴</td>
                        <td class="py-2 px-4">{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} ₴</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 text-right">
                <span class="font-bold text-lg">Всього: {{ number_format($cartItems->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', ' ') }} ₴</span>
            </div>
        @endif
    </div>
@endsection
