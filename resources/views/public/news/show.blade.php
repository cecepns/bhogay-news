@extends('layouts.public')

@section('title', $news->title . ' - News Portal')
@section('description', Str::limit(strip_tags($news->content), 160))

@section('meta-tags')
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $news->title }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($news->content), 160) }}" />
    <meta property="og:image" content="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : asset('images/logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ config('app.name', 'News Portal') }}" />
    <meta property="article:published_time" content="{{ $news->created_at->toISOString() }}" />
    <meta property="article:modified_time" content="{{ $news->updated_at->toISOString() }}" />
    <meta property="article:author" content="{{ config('app.name', 'News Portal') }}" />
    @if($news->category)
    <meta property="article:section" content="{{ $news->category->name }}" />
    @endif
    @foreach($news->tags as $tag)
    <meta property="article:tag" content="{{ $tag->name }}" />
    @endforeach

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $news->title }}" />
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($news->content), 160) }}" />
    <meta name="twitter:image" content="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : asset('images/logo.png') }}" />
    <meta name="twitter:url" content="{{ url()->current() }}" />

    <!-- Additional Meta Tags -->
    <meta name="description" content="{{ Str::limit(strip_tags($news->content), 160) }}" />
    <meta name="keywords" content="{{ $news->tags->pluck('name')->implode(', ') }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
@endsection

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

            <span class="breadcrumb-item f1-s-3 cl9">
                {{ $news->title }}
            </span>
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

<section class="bg0 p-b-70 p-t-5">
    <!-- Title -->
    <div class="bg-img1 size-a-18 how-overlay1" style="background-image: url({{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : 'https://placehold.co/600x400/E8E8E8/A7A6A6.png?text=Post+Thumbnail' }});">
        <div class="container h-full flex-col-e-c p-b-58">
            <a href="{{ route('news.index', ['category' => $news->category->slug]) }}" class="f1-s-10 cl0 hov-cl10 trans-03 text-uppercase txt-center m-b-33">
                {{ $news->category->name }}
            </a>

            <h3 class="f1-l-5 cl0 p-b-16 txt-center respon2">
                {{ $news->title }}
            </h3>

            <div class="flex-wr-c-s">
                <span class="f1-s-3 cl8 m-rl-7 txt-center">
                    <span>
                        {{ $news->updated_at->format('M d') }}
                    </span>
                </span>
            </div>
        </div>
    </div>

    <!-- Detail -->
    <div class="container p-t-82">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 p-b-100">
                <div class="p-r-10 p-r-0-sr991">
                    <!-- Blog Detail -->
                    <div class="p-b-70">
                        <div class="f1-s-11 cl6 p-b-25">
                            {!! $news->content !!}
                        </div>

                        @if($news->tags->count() > 0)
                        <!-- Tag -->
                        <div class="flex-s-s p-t-12 p-b-15">
                            <span class="f1-s-12 cl5 m-r-8">
                                Tags:
                            </span>
                            
                            <div class="flex-wr-s-s size-w-0">
                                @foreach($news->tags as $tag)
                                <a href="{{ route('news.byTag', $tag->slug) }}" class="f1-s-12 cl8 hov-link1 m-r-15">
                                    {{ $tag->name }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-10 col-lg-4 p-b-100">
                <div class="p-l-10 p-rl-0-sr991">

                    <div class="p-b-50">
                        <h4 class="f1-l-4 cl3 p-b-12">
                            Most Viewed
                        </h4>

                        @foreach($mostViewedNews ?? [] as $popular)
                        <div class="flex-wr-sb-s p-b-20">
                            <a href="{{ route('news.show', $popular->slug) }}" class="size-w-1 wrap-pic-w">
                                <img src="{{ $popular->thumbnail ? asset('storage/' . $popular->thumbnail) : 'https://placehold.co/100x100/E8E8E8/A7A6A6.png?text=News' }}" alt="{{ $popular->title }}">
                            </a>

                            <div class="size-w-2">
                                <h5 class="p-b-5">
                                    <a href="{{ route('news.show', $popular->slug) }}" class="f1-s-5 cl3 hov-cl10 trans-03">
                                        {{ $popular->title }}
                                    </a>
                                </h5>

                                <span class="cl8">
                                    <span class="f1-s-6 cl8">
                                        {{ $popular->updated_at->format('M d, Y') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    
                    <div>
                        @include('components.advertisement', ['size' => '160x300'])
                    </div>
                </div>
            </div>
        </div>
    </div>
	</section>
@endsection 