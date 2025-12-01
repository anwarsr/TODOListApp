<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

/**
 * CategorySeeder
 * 
 * Seeder untuk mengisi tabel categories dengan data kategori default
 * Saat ini belum digunakan karena fitur kategori belum diimplementasikan
 */
class CategorySeeder extends Seeder
{
    /**
     * Jalankan seeder untuk mengisi kategori default
     */
    public function run()
    {
        // Daftar kategori default untuk task
        $categories = [
            ['name' => 'Personal', 'color' => '#007bff'],
            ['name' => 'Work', 'color' => '#28a745'],
            ['name' => 'Shopping', 'color' => '#ffc107'],
            ['name' => 'Health', 'color' => '#dc3545'],
            ['name' => 'Education', 'color' => '#6f42c1'],
            ['name' => 'Urgent', 'color' => '#fd7e14'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}