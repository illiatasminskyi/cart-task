<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Ноутбук Lenovo ThinkPad',
            'description' => 'Потужний ноутбук для роботи та ігор.',
            'price' => 25000.00,
            'image' => 'https://via.placeholder.com/300x200?text=Laptop',
        ]);

        Product::create([
            'name' => 'Смартфон Samsung Galaxy',
            'description' => 'Сучасний смартфон з великим екраном.',
            'price' => 15000.00,
            'image' => 'https://via.placeholder.com/300x200?text=Phone',
        ]);

        Product::create([
            'name' => 'Навушники Sony',
            'description' => 'Бездротові навушники з шумозаглушенням.',
            'price' => 3000.00,
            'image' => 'https://via.placeholder.com/300x200?text=Headphones',
        ]);

        Product::create([
            'name' => 'Миша Logitech',
            'description' => 'Ергономічна миша для комп\'ютера.',
            'price' => 500.00,
            'image' => 'https://via.placeholder.com/300x200?text=Mouse',
        ]);

        Product::create([
            'name' => 'Клавіатура Mechanical',
            'description' => 'Механічна клавіатура з підсвіткою.',
            'price' => 2000.00,
            'image' => 'https://via.placeholder.com/300x200?text=Keyboard',
        ]);
    }
}
