<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('catalog');
})->name('home');

Route::get('/product/{id}', function ($id) {
    // Фейкові дані для товару
    $products = [
        1 => ['id' => 1, 'name' => 'Ноутбук Lenovo ThinkPad', 'description' => 'Потужний ноутбук для роботи та ігор.', 'price' => 25000, 'image' => 'https://via.placeholder.com/300x200?text=Laptop'],
        2 => ['id' => 2, 'name' => 'Смартфон Samsung Galaxy', 'description' => 'Сучасний смартфон з великим екраном.', 'price' => 15000, 'image' => 'https://via.placeholder.com/300x200?text=Phone'],
        3 => ['id' => 3, 'name' => 'Навушники Sony', 'description' => 'Бездротові навушники з шумозаглушенням.', 'price' => 3000, 'image' => 'https://via.placeholder.com/300x200?text=Headphones'],
        4 => ['id' => 4, 'name' => 'Миша Logitech', 'description' => 'Ергономічна миша для комп\'ютера.', 'price' => 500, 'image' => 'https://via.placeholder.com/300x200?text=Mouse'],
        5 => ['id' => 5, 'name' => 'Клавіатура Mechanical', 'description' => 'Механічна клавіатура з підсвіткою.', 'price' => 2000, 'image' => 'https://via.placeholder.com/300x200?text=Keyboard'],
    ];

    $product = $products[$id] ?? null;
    if (!$product) abort(404);

    return view('product', compact('product'));
})->name('product.show');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
