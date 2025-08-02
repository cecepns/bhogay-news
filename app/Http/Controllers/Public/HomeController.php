<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Tag;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * Display the news portal homepage.
     */
    public function index(Request $request): View
    {
        // Track page view
        $this->trackPageView($request, 'home');

        // Get featured news for carousel (random 5 from top 30 most viewed)
        $featuredNews = News::published()
            ->with('category')
            ->mostViewed()
            ->take(30)
            ->inRandomOrder()
            ->take(5)
            ->get();

        // Get latest news (excluding featured ones)
        $latestNews = News::published()
            ->with('category')
            ->whereNotIn('id', $featuredNews->pluck('id'))
            ->latest()
            ->take(50)
            ->inRandomOrder()
            ->take(8)
            ->get();

        // Get most viewed news
        $mostViewedNews = News::published()
            ->with('category')
            ->mostViewed()
            ->take(5)
            ->get();

        // Get active ads
        $banner300x250 = Ad::active()->where('size', '300x250')->get();

        // Get categories for navigation
        $categories = Category::withCount('publishedNews')->get();

        // Get popular tags with news count
        $tags = Tag::withCount('news')
            ->orderBy('news_count', 'desc')
            ->take(10)
            ->get();

        return view('public.home', compact(
            'featuredNews',
            'latestNews', 
            'mostViewedNews',
            'banner300x250',
            'categories',
            'tags'
        ));
    }

    /**
     * Track page view for analytics.
     */
    private function trackPageView(Request $request, string $pageType, ?int $newsId = null): void
    {
        PageView::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'page_type' => $pageType,
            'news_id' => $newsId,
            'viewed_at' => now(),
        ]);
    }
}
