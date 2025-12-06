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
            'image' => 'https://images.unsplash.com/photo-1593642634315-48f5414c3ad9?q=80&w=1169&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ]);

        Product::create([
            'name' => 'Смартфон Samsung Galaxy',
            'description' => 'Сучасний смартфон з великим екраном.',
            'price' => 15000.00,
            'image' => 'https://images.unsplash.com/photo-1732645683133-2628fcfd3628?q=80&w=736&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ]);

        Product::create([
            'name' => 'Навушники Sony',
            'description' => 'Бездротові навушники з шумозаглушенням.',
            'price' => 3000.00,
            'image' => 'https://plus.unsplash.com/premium_photo-1679513691474-73102089c117?q=80&w=1113&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ]);

        Product::create([
            'name' => 'Миша Logitech',
            'description' => 'Ергономічна миша для комп\'ютера.',
            'price' => 500.00,
            'image' => 'https://images.unsplash.com/photo-1752442534054-ef5b221c39a3?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ]);

        Product::create([
            'name' => 'Клавіатура Mechanical',
            'description' => 'Механічна клавіатура з підсвіткою.',
            'price' => 2000.00,
            'image' => 'https://images.unsplash.com/photo-1727504563741-ed8bd9bf5e4d?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ]);
    }
}
