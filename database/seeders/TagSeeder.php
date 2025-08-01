<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip if tags already exist (except for factory data)
        if (Tag::whereNotIn('name', ['Politik', 'Ekonomi', 'Olahraga', 'Teknologi', 'Kesehatan', 'Pendidikan', 'Hiburan', 'Wisata', 'Kuliner', 'Internasional'])->exists()) {
            return;
        }

        // ANCHOR: Create predefined tags
        $tags = [
            'Politik', 'Ekonomi', 'Olahraga', 'Teknologi', 'Kesehatan',
            'Pendidikan', 'Hiburan', 'Wisata', 'Kuliner', 'Internasional'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate([
                'name' => $tagName,
            ], [
                'slug' => \Illuminate\Support\Str::slug($tagName),
            ]);
        }
    }
}
