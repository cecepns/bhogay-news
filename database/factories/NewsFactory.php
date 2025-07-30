<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * ANCHOR: Factory untuk News Model dengan data dummy yang realistic
     */
    public function definition(): array
    {
        $titles = [
            'Teknologi AI Terbaru Mengubah Industri',
            'Pemilu 2024: Analisis Politik Terkini',
            'Ekonomi Indonesia di Era Digital',
            'Olahraga: Timnas Indonesia Juara',
            'Hiburan: Film Terbaru Sukses Besar',
            'Kesehatan: Tips Hidup Sehat Modern',
            'Pendidikan: Sistem Belajar Online',
            'Lingkungan: Gerakan Go Green',
            'Internasional: Berita Dunia Hari Ini',
            'Nasional: Pembangunan Infrastruktur',
            'Bisnis: Startup Unicorn Indonesia',
            'Otomotif: Mobil Listrik Terbaru',
            'Gaya Hidup: Tren Fashion 2024',
            'Sains: Penemuan Terbaru',
            'Teknologi: Blockchain dan Cryptocurrency'
        ];

        $title = fake()->randomElement($titles) . ' - ' . fake()->sentence(3);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->generateNewsContent(),
            'thumbnail' => null,
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'views' => fake()->numberBetween(0, 10000),
            'status' => fake()->randomElement(['draft', 'published']),
        ];
    }

    /**
     * ANCHOR: State untuk berita yang sudah published
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'views' => fake()->numberBetween(100, 5000),
        ]);
    }

    /**
     * ANCHOR: State untuk berita draft
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'views' => 0,
        ]);
    }

    /**
     * ANCHOR: State untuk berita populer (banyak views)
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'views' => fake()->numberBetween(5000, 50000),
        ]);
    }

    /**
     * ANCHOR: State untuk berita breaking news
     */
    public function breaking(): static
    {
        return $this->state(fn (array $attributes) => [
            'title' => 'BREAKING: ' . fake()->sentence(5),
            'status' => 'published',
            'views' => fake()->numberBetween(1000, 10000),
        ]);
    }

    /**
     * ANCHOR: Generate realistic news content
     */
    private function generateNewsContent(): string
    {
        $paragraphs = [];
        
        // Introduction paragraph
        $paragraphs[] = fake()->paragraph(3);
        
        // Main content paragraphs
        for ($i = 0; $i < fake()->numberBetween(3, 6); $i++) {
            $paragraphs[] = fake()->paragraph(4);
        }
        
        // Quote or highlight
        if (fake()->boolean(30)) {
            $paragraphs[] = '<blockquote>' . fake()->sentence(10) . '</blockquote>';
        }
        
        // Conclusion paragraph
        $paragraphs[] = fake()->paragraph(2);
        
        return implode("\n\n", $paragraphs);
    }
}
