<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\Ad;
use App\Models\PageView;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Display a listing of news with pagination.
     */
    public function index(Request $request): View
    {
        $query = News::published()->with('category')->latest();

        // Handle search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Handle category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $news = $query->paginate(12);

        // Get categories for filter
        $categories = Category::withCount('publishedNews')->get();
        
        // Get sidebar ads
        $sidebarAds = Ad::active()->byPosition('sidebar')->get();
        
        // Get most viewed news for sidebar
        $mostViewedNews = News::published()
            ->with('category')
            ->mostViewed()
            ->take(5)
            ->get();

        return view('public.news.index', compact(
            'news',
            'categories',
            'sidebarAds',
            'mostViewedNews'
        ));
    }

    /**
     * Display the specified news article.
     */
    public function show(Request $request, string $slug): View
    {
        $news = News::published()
            ->with(['category', 'pageViews'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views and track page view
        $news->incrementViews();
        $this->trackPageView($request, 'news', $news->id);

        // Get related news (same category, excluding current)
        $relatedNews = News::published()
            ->with('category')
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(4)
            ->get();

        // Get sidebar ads
        $sidebarAds = Ad::active()->byPosition('sidebar')->get();
        
        // Get content ads
        $contentAds = Ad::active()->byPosition('content-top')->get();

        return view('public.news.show', compact(
            'news',
            'relatedNews',
            'sidebarAds',
            'contentAds'
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
