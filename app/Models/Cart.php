<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function addProduct($productId, $quantity = 1, $userId = null)
    {
        $item = $this->items()->where('product_id', $productId)->first();
        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'user_id' => $userId,
            ]);
        }
    }

    public function updateProduct($itemId, $quantity)
    {
        $item = $this->items()->where('id', $itemId)->first();
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
        }
    }

    public function removeProduct($itemId)
    {
        $item = $this->items()->where('id', $itemId)->first();
        if ($item) {
            $item->delete();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
