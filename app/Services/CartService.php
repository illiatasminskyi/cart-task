<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartService implements CartServiceInterface
{
    public function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ]);
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate([
                'session_id' => $sessionId,
            ]);
        }
        return $cart;
    }

    public function addProduct(Cart $cart, $productId, $quantity = 1, $userId = null)
    {
        $item = $cart->items()->where('product_id', $productId)->first();
        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'user_id' => $userId,
            ]);
        }
    }

    public function updateProduct(Cart $cart, $itemId, $quantity)
    {
        $item = $cart->items()->where('id', $itemId)->first();
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
        }
    }

    public function removeProduct(Cart $cart, $itemId)
    {
        $item = $cart->items()->where('id', $itemId)->first();
        if ($item) {
            $item->delete();
        }
    }
}
