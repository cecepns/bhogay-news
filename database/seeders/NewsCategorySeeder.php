<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ANCHOR: Ensure all news have categories
        $news = News::whereNull('category_id')->get();
        $categories = Category::all();

        if ($news->count() > 0 && $categories->count() > 0) {
            foreach ($news as $article) {
                // Assign random category if news doesn't have one
                $randomCategory = $categories->random();
                $article->update(['category_id' => $randomCategory->id]);
            }
        }
    }
} 