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
                        <th class="py-2 px-4">Зображення</th>
                        <th class="py-2 px-4">Товар</th>
                        <th class="py-2 px-4">Кількість</th>
                        <th class="py-2 px-4">Ціна</th>
                        <th class="py-2 px-4">Сума</th>
                        <th class="py-2 px-4">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="py-2 px-4">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-20 h-14 object-cover rounded border" />
                        </td>
                        <td class="py-2 px-4">{{ $item->product->name }}</td>
                        <td class="py-2 px-4">
                            <form method="POST" action="{{ route('cart.update') }}" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="100" class="w-16 border rounded px-2 py-1">
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Оновити</button>
                            </form>
                        </td>
                        <td class="py-2 px-4">{{ number_format($item->product->price, 0, ',', ' ') }} ₴</td>
                        <td class="py-2 px-4">{{ number_format($item->product->price * $item->quantity, 0, ',', ' ') }} ₴</td>
                        <td class="py-2 px-4">
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('Видалити товар з кошика?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Видалити</button>
                            </form>
                        </td>
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
