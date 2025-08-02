@extends('layouts.public')

@section('title', isset($tag) ? $tag->name . ' - News Portal' : (request('category') ? ($categories->where('slug', request('category'))->first()?->name ?? 'Category') . ' - News Portal' : 'All News - News Portal'))
@section('description', isset($tag) ? 'Browse all ' . $tag->name . ' news and updates' : (request('category') ? 'Browse all ' . ($categories->where('slug', request('category'))->first()?->name ?? 'Category') . ' news and updates' : 'Browse all the latest news and updates'))

@section('content')

<div class="container">
    <div class="headline bg0 flex-wr-sb-c p-rl-20 p-tb-8">
        <div class="f2-s-1 p-r-30 m-tb-6">
            <a href="{{ route('home') }}" class="breadcrumb-item f1-s-3 cl9">
                Home 
            </a>

            <a href="{{ route('news.index') }}" class="breadcrumb-item f1-s-3 cl9">
                News 
            </a>
        </div>

        <form action="{{ route('news.index') }}" method="GET" class="pos-relative size-a-2 bo-1-rad-22 of-hidden bocl11 m-tb-6">
            <input
                class="f1-s-1 cl6 plh9 s-full p-l-25 p-r-45"
                type="text"
                name="search"
                placeholder="Search"
                value="{{ request('search') }}"
                aria-label="Search news"
            >
            <button type="submit" class="flex-c-c size-a-1 ab-t-r fs-20 cl2 hov-cl10 trans-03" aria-label="Search">
                <i class="zmdi zmdi-search"></i>
            </button>
        </form>
    </div>
</div>

<section class="bg0 p-b-55">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 p-b-80">
                @php
                    $resultText = '';
                    $hasFilter = false;
                    if(request('search')) {
                        $resultText = 'Search results for "' . e(request('search')) . '"';
                        $hasFilter = true;
                    } elseif(isset($tag)) {
                        $resultText = 'News with tag "' . e($tag->name) . '"';
                        $hasFilter = true;
                    } elseif(request('category')) {
                        $categoryName = $categories->where('slug', request('category'))->first()?->name ?? 'Category';
                        $resultText = 'News in category "' . e($categoryName) . '"';
                        $hasFilter = true;
                    }
                @endphp
                @if($hasFilter)
                    <div class="mb-4 d-flex align-items-center flex-wrap gap-2">
                        <span class="badge badge-pill badge-primary px-3 py-2" style="font-size:1rem;">
                            {{ $news->total() }} results
                            @if($resultText)
                                &mdash; {{ $resultText }}
                            @endif
                        </span>
                        <a href="{{ route('news.index') }}" class="btn btn-sm btn-outline-secondary ml-2">
                            Clear Filter
                        </a>
                    </div>
                @endif

                @if($news->count() > 0)
                    <div class="row">
                        @foreach($news as $item)
                            <div class="col-sm-6 p-r-25 p-r-15-sr991">
                                <!-- Item latest -->	
                                <div class="m-b-45">
                                    <a href="{{ route('news.show', $item->slug) }}" class="wrap-pic-w hov1 trans-03">
                                        @if($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}">
                                        @else
                                            <img src="https://placehold.co/100x100/E8E8E8/A7A6A6.png?text=News" alt="{{ $item->title }}">
                                        @endif
                                    </a>

                                    <div class="p-t-16">
                                        <h5 class="p-b-5">
                                            <a href="{{ route('news.show', $item->slug) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
                                                {{ $item->title }}
                                            </a>
                                        </h5>

                                        <span class="cl8">
                                            @if($item->category)
                                                <a href="{{ route('news.index', ['category' => $item->category->slug]) }}" class="f1-s-4 cl8 hov-cl10 trans-03">
                                                    {{ $item->category->name }}
                                                </a>
                                            @endif

                                            <span class="f1-s-3 m-rl-3">
                                                -
                                            </span>

                                            <span class="f1-s-3">
                                                {{ $item->created_at->format('M d') }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($news->hasPages())
                        <div class="flex-wr-s-c m-rl--7 p-t-15">
                            {{ $news->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    @endif
                @else
                    <div class="text-center p-t-50">
                        <h3 class="f1-m-2 cl3">No news found</h3>
                        <p class="f1-s-1 cl6">Try adjusting your search criteria or browse all news.</p>
                    </div>
                @endif
            </div>

            <div class="col-md-10 col-lg-4 p-b-80">
                <div class="p-l-10 p-rl-0-sr991">	
                    <div class="p-b-30">
                        @include('components.advertisement', ['size' => '468x60'])
                    </div>
                                                                    
                    <!-- Categories -->
                    @if($categories->count() > 0)
                        <div class="m-b-50">
                            <div class="how2 how2-cl4 flex-s-c m-b-20">
                                <h3 class="f1-m-2 cl3 tab01-title">
                                    Categories
                                </h3>
                            </div>

                            <div class="flex-wr-s-s m-rl--5">
                                 @foreach($categories as $category)
                                    <a href="{{ route('news.index', ['category' => $category->slug]) }}" class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                        {{ $category->name }} ({{ $category->published_news_count ?? 0 }})
                                    </a>
                                 @endforeach
                             </div>	
                        </div>
                    @endif

                    <!-- Tag -->
                    @if($tags->count() > 0)
                        <div>
                            <div class="how2 how2-cl4 flex-s-c m-b-20">
                            <h3 class="f1-m-2 cl3 tab01-title">
                                Tags
                            </h3>
                        </div>
                        <div class="flex-wr-s-s m-rl--5">
                            @foreach($tags as $tag)
                                <a href="{{ route('news.index', ['tag' => $tag->slug]) }}" class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
                                    {{ $tag->name }} ({{ $tag->published_news_count ?? 0 }})
                                </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="p-b-30">
                        @include('components.advertisement', ['size' => '160x300'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 