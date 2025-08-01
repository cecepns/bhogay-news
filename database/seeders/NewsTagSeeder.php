<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ANCHOR: Attach tags to existing news
        $news = News::published()->get();
        $tags = Tag::all();

        if ($news->count() > 0 && $tags->count() > 0) {
            foreach ($news as $article) {
                // Skip if news already has tags
                if ($article->tags()->count() > 0) {
                    continue;
                }
                
                // Attach 1-3 random tags to each news
                $randomTags = $tags->random(rand(1, 3));
                $article->tags()->attach($randomTags->pluck('id'));
            }
        }
    }
} 