<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\Category::insert([
        ['name' => 'Elektronik', 'slug' => 'elektronik', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Gıda', 'slug' => 'gida', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Tekstil', 'slug' => 'tekstil', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}
