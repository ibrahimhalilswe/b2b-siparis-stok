<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\Product::insert([
        ['category_id' => 1, 'name' => 'Kablosuz Kulaklık', 'sku' => 'ELK-001', 'price' => 899.90, 'stock' => 25, 'created_at' => now(), 'updated_at' => now()],
        ['category_id' => 1, 'name' => 'Bluetooth Hoparlör', 'sku' => 'ELK-002', 'price' => 649.50, 'stock' => 0, 'created_at' => now(), 'updated_at' => now()],
        ['category_id' => 2, 'name' => 'Zeytinyağı 5L', 'sku' => 'GID-001', 'price' => 1200.00, 'stock' => 40, 'created_at' => now(), 'updated_at' => now()],
        ['category_id' => 3, 'name' => 'Pamuklu Tişört', 'sku' => 'TEK-001', 'price' => 149.90, 'stock' => 100, 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}
