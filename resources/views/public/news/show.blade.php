@extends('layouts.public')

@section('title', $news->title . ' - News Portal')
@section('description', Str::limit(strip_tags($news->content), 160))

@section('content')
<div class="container">
    <!-- Content Top Ads -->
    @if(isset($contentAds) && $contentAds->count() > 0)
        <div class="ad-banner mb-4">
            @foreach($contentAds as $ad)
                <a href="{{ $ad->link_url }}" target="_blank">
                    <img src="{{ asset('storage/' . $ad->image_url) }}" 
                         alt="{{ $ad->title }}" 
                         class="img-fluid">
                </a>
            @endforeach
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-9">
            <article class="card">
                <div class="card-body">
                    <!-- Article Header -->
                    <div class="mb-4">
                        <div class="mb-3">
                            <a href="{{ route('news.index', ['category' => $news->category->slug]) }}" class="category-badge">
                                {{ $news->category->name }}
                            </a>
                        </div>
                        
                        <h1 class="mb-3">{{ $news->title }}</h1>
                        
                        <div class="news-meta border-bottom pb-3 mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i> Published on {{ $news->created_at->format('F d, Y') }}
                                        <i class="fas fa-clock ms-3"></i> {{ $news->created_at->format('h:i A') }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <small class="text-muted">
                                        <i class="fas fa-eye"></i> {{ number_format($news->views) }} views
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if($news->thumbnail)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $news->thumbnail) }}" 
                                 alt="{{ $news->title }}" 
                                 class="img-fluid rounded">
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div id="news-content-wrapper" class="news-content">
                        {!! $news->content !!}
                    </div>

                    <!-- Share Buttons -->
                    <div class="border-top pt-4 mt-4">
                        <h6>Share this article:</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}" 
                               target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($news->title . ' ' . request()->fullUrl()) }}" 
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Related Articles -->
            @if($relatedNews->count() > 0)
                <div class="mt-5">
                    <h3 class="border-bottom border-primary pb-2 mb-4">
                        Related Articles
                    </h3>
                    <div class="row">
                        @foreach($relatedNews as $related)
                            <div class="col-md-6 mb-4">
                                <div class="card news-card h-100 position-relative">
                                    <a href="{{ route('news.show', $related->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        <img src="{{ $related->thumbnail ? asset('storage/' . $related->thumbnail) : 'https://placehold.co/300x200?text=News+Image' }}" 
                                             class="card-img-top news-thumbnail" alt="{{ $related->title }}">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{ $related->title }}
                                            </h5>
                                            <p class="card-text">{{ Str::limit(strip_tags($related->content), 120) }}</p>
                                            <div class="news-meta">
                                                <small>
                                                    <i class="fas fa-calendar"></i> {{ $related->created_at->format('M d, Y') }}
                                                    <i class="fas fa-eye ms-2"></i> {{ number_format($related->views) }} views
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

            <!-- Latest News -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clock"></i> Latest News
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $latestNews = App\Models\News::published()->with('category')->latest()->take(5)->get();
                    @endphp
                    
                    @foreach($latestNews as $latest)
                        <div class="sidebar-news">
                            <h6>
                                <a href="{{ route('news.show', $latest->slug) }}" class="text-decoration-none">
                                    {{ Str::limit($latest->title, 60) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $latest->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 