<?php

namespace App\Providers;

use App\Models\Cart;
use App\Services\CartService;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Services\CartServiceInterface;
use App\Http\Middleware\MergeGuestCart;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CartRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::pushMiddlewareToGroup('web', MergeGuestCart::class);

        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->first();
            } else {
                $sessionId = session()->getId();
                $cart = Cart::where('session_id', $sessionId)->first();
            }
            if ($cart) {
                $cartCount = $cart->items()->sum('quantity');
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
