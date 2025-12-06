<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('products seeder creates expected products', function () {
    $this->seed(\Database\Seeders\ProductSeeder::class);

    expect(Product::count())->toBe(5);
    expect(Product::where('name', 'Ноутбук Lenovo ThinkPad')->exists())->toBeTrue();
    expect(Product::where('name', 'Смартфон Samsung Galaxy')->exists())->toBeTrue();
    expect(Product::where('name', 'Навушники Sony')->exists())->toBeTrue();
    expect(Product::where('name', 'Миша Logitech')->exists())->toBeTrue();
    expect(Product::where('name', 'Клавіатура Mechanical')->exists())->toBeTrue();
});

test('product model can be created', function () {
    $product = Product::create([
        'name' => 'Тестовий продукт',
        'description' => 'Опис',
        'price' => 123.45,
        'image' => 'test.jpg',
    ]);

    expect($product->id)->not->toBeNull();
    expect($product->name)->toBe('Тестовий продукт');
    expect($product->price)->toBe(123.45);
});

test('product has cartItems relation', function () {
    $product = Product::factory()->create();
    expect(method_exists($product, 'cartItems'))->toBeTrue();
    expect($product->cartItems())->not->toBeNull();
});

test('product show page returns 200', function () {
    $product = Product::factory()->create();
    $response = $this->get(route('product.show', $product->id));
    $response->assertStatus(200);
    $response->assertSee($product->name);
});

test('product show page returns 404 for missing product', function () {
    $response = $this->get(route('product.show', 999999));
    $response->assertStatus(404);
});

test('home page shows products', function () {
    $products = Product::factory()->count(3)->create();
    $response = $this->get(route('home'));
    $response->assertStatus(200);
    foreach ($products as $product) {
        $response->assertSee($product->name);
    }
});
