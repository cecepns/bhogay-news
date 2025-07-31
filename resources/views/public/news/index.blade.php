@extends('layouts.public')

@section('title', request('category') ? ($categories->where('slug', request('category'))->first()?->name ?? 'Category') . ' - News Portal' : 'All News - News Portal')
@section('description', request('category') ? 'Browse all ' . ($categories->where('slug', request('category'))->first()?->name ?? 'Category') . ' news and updates' : 'Browse all the latest news and updates')

@section('content')
<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    @if(request('category'))
                        @php
                            $currentCategory = $categories->where('slug', request('category'))->first();
                        @endphp
                        <h1>{{ $currentCategory ? $currentCategory->name : 'Category' }}</h1>
                        @if($currentCategory && $currentCategory->description)
                            <p class="text-muted">{{ $currentCategory->description }}</p>
                        @endif
                    @else
                        <h1>All News</h1>
                    @endif
                </div>
                <div class="text-muted">
                    {{ $news->total() }} articles found
                </div>
            </div>

            <!-- Search Results -->
            @if(request('search'))
                <div class="alert alert-info mb-4">
                    <i class="fas fa-search"></i> Search results for: <strong>"{{ request('search') }}"</strong>
                    <a href="{{ route('news.index') }}" class="btn btn-sm btn-outline-primary ms-2">Clear</a>
                </div>
            @endif

            <!-- News Grid -->
            @if($news->count() > 0)
                <div class="row">
                    @foreach($news as $article)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card news-card h-100 position-relative">
                                <a href="{{ route('news.show', $article->slug) }}" class="text-decoration-none text-dark stretched-link">
                                    <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://placehold.co/300x200?text=News+Image' }}" 
                                         class="card-img-top news-thumbnail" alt="{{ $article->title }}">
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-2">
                                            <span class="category-badge">
                                                {{ $article->category->name }}
                                            </span>
                                        </div>
                                        <h5 class="card-title">
                                            {{ $article->title }}
                                        </h5>
                                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                                        <div class="news-meta">
                                            <small>
                                                <i class="fas fa-calendar"></i> {{ $article->created_at->format('M d, Y') }}
                                                <i class="fas fa-eye ms-2"></i> {{ number_format($article->views) }} views
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->links('vendor.pagination.custom') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">
                        @if(request('category'))
                            No news articles found in {{ $categories->where('slug', request('category'))->first()?->name ?? 'this category' }}
                        @else
                            No news articles found
                        @endif
                    </h4>
                    @if(request('search'))
                        <p class="text-muted">Try adjusting your search terms or browse all categories.</p>
                    @elseif(request('category'))
                        <p class="text-muted">Check back later for the latest updates in this category.</p>
                        <a href="{{ route('news.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Browse All News
                        </a>
                    @else
                        <p class="text-muted">Check back later for the latest updates.</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-3">
            <!-- Categories Filter -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-filter"></i> Filter by Category
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('news.index') }}" 
                           class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                            All Categories
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('news.index', ['category' => $category->slug]) }}" 
                               class="list-group-item list-group-item-action {{ request('category') === $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                                <span class="badge bg-secondary float-end">{{ $category->published_news_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

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

            <!-- Most Viewed -->
            @if($mostViewedNews->count() > 0)
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-fire"></i> Most Viewed
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach($mostViewedNews as $index => $article)
                            <div class="sidebar-news">
                                <h6>
                                    <span class="badge bg-secondary me-2">{{ $index + 1 }}</span>
                                    <a href="{{ route('news.show', $article->slug) }}" class="text-decoration-none">
                                        {{ Str::limit($article->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ number_format($article->views) }} views
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 