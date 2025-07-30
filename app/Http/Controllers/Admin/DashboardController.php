<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PageView;
use App\Models\Category;
use App\Models\Ad;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     */
    public function index(): View
    {
        // Get statistics
        $totalNews = News::count();
        $totalNewsToday = News::whereDate('created_at', today())->count();
        $totalViews = News::sum('views');
        $totalVisitors = PageView::distinct('ip_address')->count();
        
        // Get recent news
        $recentNews = News::with('category')
            ->latest()
            ->take(5)
            ->get();
            
        // Get most viewed news
        $mostViewedNews = News::with('category')
            ->mostViewed()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalNews',
            'totalNewsToday', 
            'totalViews',
            'totalVisitors',
            'recentNews',
            'mostViewedNews'
        ));
    }
}
