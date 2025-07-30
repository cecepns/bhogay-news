@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card text-center p-3">
                <div class="card-body">
                    <i class="fas fa-newspaper fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ number_format($totalNews) }}</h3>
                    <p class="mb-0">Total News</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card success text-center p-3">
                <div class="card-body">
                    <i class="fas fa-plus-circle fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ number_format($totalNewsToday) }}</h3>
                    <p class="mb-0">News Today</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card warning text-center p-3">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ number_format($totalViews) }}</h3>
                    <p class="mb-0">Total Views</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card danger text-center p-3">
                <div class="card-body">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h3 class="mb-0">{{ number_format($totalVisitors) }}</h3>
                    <p class="mb-0">Total Visitors</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.news.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus"></i> Add News
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-tag"></i> Add Category
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.ads.create') }}" class="btn btn-warning w-100">
                                <i class="fas fa-ad"></i> Add Advertisement
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('home') }}" target="_blank" class="btn btn-info w-100">
                                <i class="fas fa-external-link-alt"></i> View Site
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent News -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-newspaper"></i> Recent News
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($recentNews as $news)
                        <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('admin.news.show', $news) }}" class="text-decoration-none">
                                        {{ Str::limit($news->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <span class="badge badge-{{ $news->status === 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($news->status) }}
                                    </span>
                                    {{ $news->category->name }} • {{ $news->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ number_format($news->views) }}
                                </small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No news articles yet.</p>
                            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create First News
                            </a>
                        </div>
                    @endforelse
                    
                    @if($recentNews->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-primary btn-sm">
                                View All News
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Most Viewed News -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-fire"></i> Most Viewed News
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($mostViewedNews as $index => $news)
                        <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                    <a href="{{ route('admin.news.show', $news) }}" class="text-decoration-none">
                                        {{ Str::limit($news->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $news->category->name }} • {{ $news->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <h6 class="text-primary mb-0">{{ number_format($news->views) }}</h6>
                                <small class="text-muted">views</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No view data available yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection 