<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Politik', 'Ekonomi', 'Olahraga', 'Teknologi', 'Kesehatan',
            'Pendidikan', 'Hiburan', 'Wisata', 'Kuliner', 'Fashion',
            'Otomotif', 'Properti', 'Lingkungan', 'Sosial', 'Budaya',
            'Agama', 'Kriminal', 'Internasional', 'Nasional', 'Daerah'
        ]);

        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ];
    }
}
