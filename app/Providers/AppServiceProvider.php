<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\News;
use App\Models\Ad;

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
            // Variabel untuk navigasi - top 5 
            $topFiveCategories = Category::withCount('publishedNews')
                ->orderBy('published_news_count', 'desc')
                ->take(5)
                ->get();

            $mostViewedNewsFooter = News::published()
                ->with('category')
                ->mostViewed()
                ->take(30)
                ->inRandomOrder()
                ->take(3)
                ->get();

            $siteName = 'Bhogay News';
            $currentYear = date('Y');
            $totalNews = News::published()->count();
            $totalCategories = Category::count();

            $banner728x90 = Ad::active()->where('size', '728x90')->get();
            $banner300x250 = Ad::active()->where('size', '300x250')->get();
            $banner320x50 = Ad::active()->where('size', '320x50')->get();

            $view->with(compact(
                'topFiveCategories',
                'mostViewedNewsFooter',
                'siteName',
                'currentYear',
                'totalNews',
                'totalCategories',
                'banner728x90',
                'banner320x50',
                'banner300x250'
            ));
        });
    }
}
