<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * ANCHOR: Seeder untuk membuat dummy data news
     */
    public function run(): void
    {
        // Skip if news already exists
        if (News::count() > 0) {
            return;
        }

        // Pastikan ada categories dan tags terlebih dahulu
        $categories = Category::all();
        $tags = Tag::all();
        
        if ($categories->isEmpty()) {
            $this->call(CategorySeeder::class);
            $categories = Category::all();
        }

        if ($tags->isEmpty()) {
            $this->call(TagSeeder::class);
            $tags = Tag::all();
        }

        // Buat 50 berita published dengan tags
        News::factory(50)
            ->published()
            ->create()
            ->each(function ($news) use ($tags) {
                $news->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            });

        // Buat 20 berita draft dengan tags
        News::factory(20)
            ->draft()
            ->create()
            ->each(function ($news) use ($tags) {
                $news->tags()->attach(
                    $tags->random(rand(1, 2))->pluck('id')->toArray()
                );
            });

        // Buat 10 berita populer dengan tags
        News::factory(10)
            ->popular()
            ->create()
            ->each(function ($news) use ($tags) {
                $news->tags()->attach(
                    $tags->random(rand(2, 4))->pluck('id')->toArray()
                );
            });

        // Buat 5 breaking news dengan tags
        News::factory(5)
            ->breaking()
            ->create()
            ->each(function ($news) use ($tags) {
                $news->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
            });

        // Buat berita dengan kategori spesifik
        $this->createNewsForSpecificCategories($categories, $tags);

        // Buat berita dengan data spesifik
        $this->createSpecificNews($categories, $tags);
    }

    /**
     * ANCHOR: Buat berita untuk kategori spesifik
     */
    private function createNewsForSpecificCategories($categories, $tags): void
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
                    $news = News::factory()->create([
                        'title' => $title,
                        'category_id' => $category->id,
                        'status' => 'published',
                        'views' => fake()->numberBetween(500, 3000)
                    ]);
                    
                    // Attach relevant tags based on category
                    $relevantTags = $this->getRelevantTags($categoryName, $tags);
                    $news->tags()->attach($relevantTags);
                }
            }
        }
    }

    /**
     * ANCHOR: Get relevant tags for category
     */
    private function getRelevantTags($categoryName, $tags)
    {
        $tagMapping = [
            'Teknologi' => ['Teknologi'],
            'Politik' => ['Politik', 'Nasional'],
            'Ekonomi' => ['Ekonomi'],
            'Olahraga' => ['Olahraga'],
        ];

        $relevantTagNames = $tagMapping[$categoryName] ?? [];
        $selectedTags = $tags->whereIn('name', $relevantTagNames);
        
        // If no specific tags found, get random tags
        if ($selectedTags->isEmpty()) {
            $selectedTags = $tags->random(rand(1, 2));
        }

        return $selectedTags->pluck('id')->toArray();
    }

    /**
     * ANCHOR: Buat berita dengan data spesifik
     */
    private function createSpecificNews($categories, $tags): void
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
            $news = News::factory()->create($newsData);
            
            // Attach specific tags for each news
            if (strpos($newsData['title'], 'Presiden') !== false) {
                $politikTag = $tags->where('name', 'Politik')->first();
                if ($politikTag) {
                    $news->tags()->attach([$politikTag->id]);
                }
            } elseif (strpos($newsData['title'], 'ChatGPT') !== false) {
                $teknologiTag = $tags->where('name', 'Teknologi')->first();
                if ($teknologiTag) {
                    $news->tags()->attach([$teknologiTag->id]);
                }
            } elseif (strpos($newsData['title'], 'Rupiah') !== false) {
                $ekonomiTag = $tags->where('name', 'Ekonomi')->first();
                if ($ekonomiTag) {
                    $news->tags()->attach([$ekonomiTag->id]);
                }
            }
        }
    }
}
