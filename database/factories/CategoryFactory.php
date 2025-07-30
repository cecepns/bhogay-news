<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * ANCHOR: Factory untuk Category Model dengan data dummy yang realistic
     */
    public function definition(): array
    {
        $categories = [
            'Teknologi',
            'Politik',
            'Ekonomi',
            'Olahraga',
            'Hiburan',
            'Kesehatan',
            'Pendidikan',
            'Lingkungan',
            'Internasional',
            'Nasional',
            'Bisnis',
            'Otomotif',
            'Gaya Hidup',
            'Sains',
            'Teknologi Informasi',
            'Berita Utama',
            'Breaking News',
            'Opini',
            'Analisis',
            'Investigasi'
        ];

        $name = fake()->randomElement($categories) . ' ' . fake()->randomNumber(2);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(2),
        ];
    }

    /**
     * ANCHOR: State untuk kategori populer
     */
    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => fake()->randomElement(['Teknologi', 'Politik', 'Ekonomi', 'Olahraga']) . ' ' . fake()->randomNumber(2),
            'description' => fake()->paragraph(3),
        ]);
    }

    /**
     * ANCHOR: State untuk kategori dengan deskripsi singkat
     */
    public function shortDescription(): static
    {
        return $this->state(fn (array $attributes) => [
            'description' => fake()->sentence(),
        ]);
    }
}
