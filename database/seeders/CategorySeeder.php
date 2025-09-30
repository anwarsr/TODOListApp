<?php
// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Personal', 'color' => '#007bff'],
            ['name' => 'Work', 'color' => '#28a745'],
            ['name' => 'Shopping', 'color' => '#ffc107'],
            ['name' => 'Health', 'color' => '#dc3545'],
            ['name' => 'Education', 'color' => '#6f42c1'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}