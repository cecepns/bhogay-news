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

        // Get featured news for carousel (random selection with latest news priority)
        $latestNews = News::published()->latest()->first();
        $featuredNews = News::published()
            ->with('category')
            ->where('created_at', '>=', $latestNews ? $latestNews->created_at->subDays(30) : now()->subDays(30))
            ->inRandomOrder()
            ->take(5)
            ->get();

        // Get latest news (excluding featured ones)
        $latestNews = News::published()
            ->with('category')
            ->whereNotIn('id', $featuredNews->pluck('id'))
            ->latest()
            ->take(8)
            ->get();

        // Get most viewed news
        $mostViewedNews = News::published()
            ->with('category')
            ->mostViewed()
            ->take(6)
            ->get();

        // Get active ads by position
        $headerAds = Ad::active()->byPosition('header')->get();
        $sidebarAds = Ad::active()->byPosition('sidebar')->get();
        $footerAds = Ad::active()->byPosition('footer')->get();

        // Get categories for navigation
        $categories = Category::withCount('publishedNews')->get();

        return view('public.home', compact(
            'featuredNews',
            'latestNews', 
            'mostViewedNews',
            'headerAds',
            'sidebarAds',
            'footerAds',
            'categories'
        ));
    }

    /**
     * Display the news portal homepage.
     */
    public function indexV2(Request $request): View
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

        $mostViewedNewsFooter = News::published()
            ->with('category')
            ->mostViewed()
            ->take(30)
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Get active ads by position
        $headerAds = Ad::active()->byPosition('header')->get();
        $sidebarAds = Ad::active()->byPosition('sidebar')->get();
        $footerAds = Ad::active()->byPosition('footer')->get();

        // Get categories for navigation
        $categories = Category::withCount('publishedNews')->get();

        // Get categories for footer (top 5 with most news)
        $categoriesFooter = Category::withCount('publishedNews')
            ->orderBy('published_news_count', 'desc')
            ->take(5)
            ->get();

        // Get popular tags with news count
        $tags = Tag::withCount('news')
            ->orderBy('news_count', 'desc')
            ->take(10)
            ->get();

        return view('public.home-v2', compact(
            'featuredNews',
            'latestNews', 
            'mostViewedNews',
            'headerAds',
            'sidebarAds',
            'footerAds',
            'categories',
            'tags',
            'mostViewedNewsFooter',
            'categoriesFooter'
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
