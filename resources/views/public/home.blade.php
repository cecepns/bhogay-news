@extends('layouts.public')

@section('title', 'Home - News Portal')
@section('description', 'Latest news and updates from around the world')

@section('content')
<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- News Carousel -->
            @if($featuredNews->count() > 0)
                <div id="newsCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($featuredNews as $index => $news)
                            <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="{{ $index }}" 
                                    class="{{ $index === 0 ? 'active' : '' }}"></button>
                        @endforeach
                    </div>
                    
                    <div class="carousel-inner" style="height: 400px;">
                        @foreach($featuredNews as $index => $news)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : 'https://placehold.co/800x400?text=News+Image' }}" 
                                     class="d-block w-100" style="height: 400px; object-fit: cover;" alt="{{ $news->title }}">
                                <div class="carousel-caption d-md-block">
                                    <a href="{{ route('news.index', ['category' => $news->category->slug]) }}" class="category-badge">
                                        {{ $news->category->name }}
                                    </a>
                                    <h4 class="mt-2">{{ $news->title }}</h4>
                                    <p class="d-none d-md-block">{{ Str::limit(strip_tags($news->content), 150) }}</p>
                                    <a href="{{ route('news.show', $news->slug) }}" class="btn btn-primary">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            @endif

            <!-- Latest News Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="border-bottom border-primary pb-2 mb-4">
                        <i class="fas fa-clock text-primary"></i> Latest News
                    </h2>
                </div>
                
                @forelse($latestNews as $news)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card news-card h-100 position-relative">
                            <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none text-dark stretched-link">
                                <img src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : 'https://placehold.co/300x200?text=News+Image' }}" 
                                     class="card-img-top news-thumbnail" alt="{{ $news->title }}">
                                <div class="card-body d-flex flex-column">
                                    <div class="mb-2">
                                        <span class="category-badge">
                                            {{ $news->category->name }}
                                        </span>
                                    </div>
                                    <h5 class="card-title">
                                        {{ $news->title }}
                                    </h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($news->content), 120) }}</p>
                                    <div class="news-meta">
                                        <small>
                                            <i class="fas fa-calendar"></i> {{ $news->created_at->format('M d, Y') }}
                                            <i class="fas fa-eye ms-2"></i> {{ number_format($news->views) }} views
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No news articles available at the moment.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- View All News Button -->
            @if($latestNews->count() > 0)
                <div class="text-center mb-4">
                    <a href="{{ route('news.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> View All News
                    </a>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Sidebar Ads -->
            @if(isset($sidebarAds) && $sidebarAds->count() > 0)
                <div class="mb-4">
                    @foreach($sidebarAds as $ad)
                        <div class="ad-banner mb-3">
                            <a href="{{ $ad->link_url }}" target="_blank">
                                <img src="{{ asset('storage/' . $ad->image_url) }}" 
                                     alt="{{ $ad->title }}" 
                                     class="img-fluid">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Most Viewed News -->
            @if($mostViewedNews->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-fire"></i> Most Viewed
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($mostViewedNews as $index => $news)
                            <div class="sidebar-news">
                                <h6>
                                    <span class="badge bg-secondary me-2">{{ $index + 1 }}</span>
                                    <a href="{{ route('news.show', $news->slug) }}" class="text-decoration-none">
                                        {{ Str::limit($news->title, 60) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ number_format($news->views) }} views
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Categories -->
            @if(isset($categories) && $categories->count() > 0)
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tags"></i> Categories
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($categories as $category)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="{{ route('news.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                                    {{ $category->name }}
                                </a>
                                <span class="badge bg-light text-dark">{{ $category->published_news_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 