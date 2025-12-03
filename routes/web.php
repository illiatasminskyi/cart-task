<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('home');

Route::get('/product/{id}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');

