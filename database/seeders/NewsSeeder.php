<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * ANCHOR: Seeder untuk membuat dummy data news
     */
    public function run(): void
    {
        // Pastikan ada categories terlebih dahulu
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        // Buat 50 berita published
        News::factory(50)
            ->published()
            ->create();

        // Buat 20 berita draft
        News::factory(20)
            ->draft()
            ->create();

        // Buat 10 berita populer
        News::factory(10)
            ->popular()
            ->create();

        // Buat 5 breaking news
        News::factory(5)
            ->breaking()
            ->create();

        // Buat berita dengan kategori spesifik
        $this->createNewsForSpecificCategories($categories);

        // Buat berita dengan data spesifik
        $this->createSpecificNews($categories);
    }

    /**
     * ANCHOR: Buat berita untuk kategori spesifik
     */
    private function createNewsForSpecificCategories($categories): void
    {
        $categoryMap = [
            'Teknologi' => [
                'AI dan Machine Learning Terbaru',
                'Blockchain: Masa Depan Keuangan',
                'Cloud Computing untuk Bisnis'
            ],
            'Politik' => [
                'Analisis Pemilu 2024',
                'Kebijakan Pemerintah Terbaru',
                'Partai Politik dan Koalisi'
            ],
            'Ekonomi' => [
                'Pertumbuhan Ekonomi Indonesia',
                'Investasi Asing di Indonesia',
                'Startup Unicorn Indonesia'
            ],
            'Olahraga' => [
                'Timnas Indonesia di Piala Asia',
                'Liga Indonesia 2024',
                'Olimpiade Paris 2024'
            ]
        ];

        foreach ($categoryMap as $categoryName => $titles) {
            $category = $categories->where('name', 'like', "%{$categoryName}%")->first();
            
            if ($category) {
                foreach ($titles as $title) {
                    News::factory()->create([
                        'title' => $title,
                        'category_id' => $category->id,
                        'status' => 'published',
                        'views' => fake()->numberBetween(500, 3000)
                    ]);
                }
            }
        }
    }

    /**
     * ANCHOR: Buat berita dengan data spesifik
     */
    private function createSpecificNews($categories): void
    {
        $specificNews = [
            [
                'title' => 'BREAKING: Presiden Umumkan Kebijakan Baru',
                'category_id' => $categories->where('name', 'like', '%Politik%')->first()?->id ?? $categories->first()->id,
                'status' => 'published',
                'views' => 15000
            ],
            [
                'title' => 'Teknologi AI ChatGPT Terbaru',
                'category_id' => $categories->where('name', 'like', '%Teknologi%')->first()?->id ?? $categories->first()->id,
                'status' => 'published',
                'views' => 8000
            ],
            [
                'title' => 'Ekonomi: Rupiah Menguat Terhadap Dollar',
                'category_id' => $categories->where('name', 'like', '%Ekonomi%')->first()?->id ?? $categories->first()->id,
                'status' => 'published',
                'views' => 6000
            ]
        ];

        foreach ($specificNews as $newsData) {
            News::factory()->create($newsData);
        }
    }
}
