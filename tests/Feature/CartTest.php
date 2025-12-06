<?php

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it creates cart for authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    expect($cart)->not->toBeNull();
    expect($cart->user_id)->toBe($user->id);
    expect($cart->session_id)->toBeNull();
});

test('it creates cart for guest', function () {
    expect(auth()->guest())->toBeTrue();
    $service = new CartService();
    $cart = $service->getCart();
    expect($cart)->not->toBeNull();
    expect($cart->user_id)->toBeNull();
    expect($cart->session_id)->not->toBeNull();
});

test('it adds new product to cart', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($cart, $product->id, 2, $user->id);
    $item = $cart->items()->where('product_id', $product->id)->first();
    expect($item)->not->toBeNull();
    expect($item->quantity)->toBe(2);
});

test('it increases quantity if product already in cart', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($cart, $product->id, 1, $user->id);
    $service->addProduct($cart, $product->id, 3, $user->id);
    $item = $cart->items()->where('product_id', $product->id)->first();
    expect($item->quantity)->toBe(4);
});

test('it adds product for guest and user separately', function () {
    // Гість
    $service = new CartService();
    $guestCart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($guestCart, $product->id, 1);
    $guestItem = $guestCart->items()->where('product_id', $product->id)->first();
    expect($guestItem)->not->toBeNull();
    expect($guestItem->user_id)->toBeNull();

    // Авторизований користувач
    $user = User::factory()->create();
    $this->actingAs($user);
    $userCart = $service->getCart();
    $service->addProduct($userCart, $product->id, 2, $user->id);
    $userItem = $userCart->items()->where('product_id', $product->id)->first();
    expect($userItem)->not->toBeNull();
    expect($userItem->user_id)->toBe($user->id);
    expect($userItem->quantity)->toBe(2);
});

test('it updates quantity of existing product', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($cart, $product->id, 2, $user->id);
    $item = $cart->items()->where('product_id', $product->id)->first();
    $service->updateProduct($cart, $item->id, 5);
    $item->refresh();
    expect($item->quantity)->toBe(5);
});

test('it updates quantity to zero and removes item', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($cart, $product->id, 2, $user->id);
    $item = $cart->items()->where('product_id', $product->id)->first();
    $service->updateProduct($cart, $item->id, 0);
    $item = $cart->items()->where('product_id', $product->id)->first();
    expect($item)->toBeNull();
});

test('it removes existing product from cart', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($cart, $product->id, 2, $user->id);
    $item = $cart->items()->where('product_id', $product->id)->first();
    $service->removeProduct($cart, $item->id);
    $item = $cart->items()->where('product_id', $product->id)->first();
    expect($item)->toBeNull();
});

test('it tries to remove non-existing product from cart', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $product = Product::factory()->create();
    $service->addProduct($cart, $product->id, 2, $user->id);
    $nonExistingId = 999999;
    $service->removeProduct($cart, $nonExistingId);
    $item = $cart->items()->where('product_id', $product->id)->first();
    expect($item)->not->toBeNull();
});

test('it returns correct list of cart items', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $products = Product::factory()->count(3)->create();
    foreach ($products as $product) {
        $service->addProduct($cart, $product->id, 1, $user->id);
    }
    $items = $cart->items()->with('product')->get();
    expect($items)->toHaveCount(3);
    foreach ($items as $item) {
        expect($item->product)->not->toBeNull();
        expect($products->pluck('id'))->toContain($item->product_id);
    }
});

test('it finds cart by user_id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $service = new CartService();
    $cart = $service->getCart();
    $repo = new \App\Repositories\CartRepository();
    $found = $repo->findByUserId($user->id);
    expect($found)->not->toBeNull();
    expect($found->id)->toBe($cart->id);
});

test('it finds cart by session_id', function () {
    $service = new CartService();
    $cart = $service->getCart();
    $repo = new \App\Repositories\CartRepository();
    $found = $repo->findBySessionId($cart->session_id);
    expect($found)->not->toBeNull();
    expect($found->id)->toBe($cart->id);
});
