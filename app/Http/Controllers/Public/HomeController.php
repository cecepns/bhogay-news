<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Ad;
use App\Models\Category;
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

        // Get featured news for carousel (latest 5 published news)
        $featuredNews = News::published()
            ->with('category')
            ->latest()
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

        // Get featured news for carousel (latest 5 published news)
        $featuredNews = News::published()
            ->with('category')
            ->latest()
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
            ->take(5)
            ->get();

        // Get active ads by position
        $headerAds = Ad::active()->byPosition('header')->get();
        $sidebarAds = Ad::active()->byPosition('sidebar')->get();
        $footerAds = Ad::active()->byPosition('footer')->get();

        // Get categories for navigation
        $categories = Category::withCount('publishedNews')->get();

        return view('public.home-v2', compact(
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
