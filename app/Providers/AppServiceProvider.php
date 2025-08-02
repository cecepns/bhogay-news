<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\News;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ANCHOR: View Composer untuk variabel global di layout public
        View::composer('layouts.public', function ($view) {
            // Variabel untuk navigasi - top 5 kategori
            $topFiveCategories = Category::withCount('publishedNews')
                ->orderBy('published_news_count', 'desc')
                ->take(5)
                ->get();

            // Variabel untuk footer - berita populer
            $mostViewedNewsFooter = News::published()
                ->with('category')
                ->mostViewed()
                ->take(30)
                ->inRandomOrder()
                ->take(3)
                ->get();

            // Variabel tambahan yang bisa Anda tambahkan
            $siteName = 'Bhogay News';
            $currentYear = date('Y');
            $totalNews = News::published()->count();
            $totalCategories = Category::count();

            $view->with(compact(
                'topFiveCategories',
                'mostViewedNewsFooter',
                'siteName',
                'currentYear',
                'totalNews',
                'totalCategories'
            ));
        });
    }
}
