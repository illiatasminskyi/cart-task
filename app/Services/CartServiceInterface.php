<?php

namespace App\Services;

use App\Models\Cart;

interface CartServiceInterface
{
    public function getCart();
    public function addProduct(Cart $cart, $productId, $quantity = 1, $userId = null);
    public function updateProduct(Cart $cart, $itemId, $quantity);
    public function removeProduct(Cart $cart, $itemId);
}
