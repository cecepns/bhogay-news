<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * ANCHOR: Seeder untuk membuat dummy data categories
     */
    public function run(): void
    {
        // Buat 15 kategori dasar
        Category::factory(15)->create();
        
        // Buat 5 kategori populer dengan deskripsi lebih panjang
        Category::factory(5)->popular()->create();
        
        // Buat 3 kategori dengan deskripsi singkat
        Category::factory(3)->shortDescription()->create();
        
        // Buat kategori dengan data spesifik
        Category::create([
            'name' => 'Berita Utama',
            'slug' => 'berita-utama',
            'description' => 'Berita-berita utama dan terpenting yang sedang terjadi saat ini.',
        ]);
        
        Category::create([
            'name' => 'Breaking News',
            'slug' => 'breaking-news',
            'description' => 'Berita terbaru dan mendadak yang memerlukan perhatian khusus.',
        ]);
    }
}
