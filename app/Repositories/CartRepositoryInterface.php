<?php

namespace App\Repositories;

use App\Models\Cart;

interface CartRepositoryInterface
{
    public function findByUserId($userId);
    public function findBySessionId($sessionId);
    public function create(array $data);
    public function getItems(Cart $cart);
    public function findItem(Cart $cart, $productId);
    public function findItemById(Cart $cart, $itemId);
}
