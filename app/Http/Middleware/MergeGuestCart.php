<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class MergeGuestCart
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $sessionId = $request->session()->getId();
            $guestCart = Cart::where('session_id', $sessionId)->first();
            if ($guestCart) {
                $userCart = Cart::firstOrCreate(['user_id' => $user->id]);
                foreach ($guestCart->items as $item) {
                    $existing = $userCart->items()->where('product_id', $item->product_id)->first();
                    if ($existing) {
                        $existing->quantity += $item->quantity;
                        $existing->save();
                        $item->delete();
                    } else {
                        $item->cart_id = $userCart->id;
                        $item->user_id = $user->id;
                        $item->save();
                    }
                }
                $guestCart->delete();
            }
        }
        return $next($request);
    }
}
