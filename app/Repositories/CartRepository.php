<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartRepository implements CartRepositoryInterface
{
    public function findByUserId($userId)
    {
        return Cart::where('user_id', $userId)->first();
    }

    public function findBySessionId($sessionId)
    {
        return Cart::where('session_id', $sessionId)->first();
    }

    public function create(array $data)
    {
        return Cart::create($data);
    }

    public function getItems(Cart $cart)
    {
        return $cart->items()->with('product')->get();
    }

    public function findItem(Cart $cart, $productId)
    {
        return $cart->items()->where('product_id', $productId)->first();
    }

    public function findItemById(Cart $cart, $itemId)
    {
        return $cart->items()->where('id', $itemId)->first();
    }
}
