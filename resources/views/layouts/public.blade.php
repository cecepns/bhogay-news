<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'News Portal')</title>
    <meta name="description" content="@yield('description', 'Latest news and updates')">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* ANCHOR: Layout and Content Styles */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
            min-height: calc(100vh - 200px); /* Approximate header + footer height */
        }
        
        .news-card {
            transition: transform 0.2s;
            height: 100%;
        }
        .news-card:hover {
            transform: translateY(-5px);
        }
        .news-thumbnail {
            height: 200px;
            object-fit: cover;
        }
        .news-meta {
            font-size: 0.9em;
            color: #6c757d;
        }
        .category-badge {
            background: #007bff;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            text-decoration: none;
        }
        .carousel-caption {
            background: rgba(0,0,0,0.7);
            border-radius: 10px;
            padding: 20px;
        }
        .ad-banner {
            text-align: center;
            margin: 20px 0;
        }
        .sidebar-news {
            border-left: 3px solid #007bff;
            padding-left: 10px;
            margin-bottom: 15px;
        }
        .news-content {
            line-height: 1.8;
        }
        .news-content img {
            max-width: 100%;
            height: auto;
        }
        
        /* ANCHOR: Custom Pagination Styling */
        .pagination {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .pagination .page-item {
            margin: 0;
            padding: 0;
        }
        
        .pagination .page-link {
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #007bff;
            background-color: #fff;
            border: 1px solid #dee2e6;
            text-decoration: none;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }
        
        .pagination .page-link:hover {
            z-index: 2;
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
        
        .pagination .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
        
        .pagination * {
            box-sizing: border-box;
        }
        
        .pagination .page-link:focus {
            z-index: 3;
            color: #0056b3;
            background-color: #e9ecef;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header class="bg-primary text-white">
        <div class="container">
            <!-- Header Ads -->
            @if(isset($headerAds) && $headerAds->count() > 0)
                <div class="ad-banner py-2">
                    @foreach($headerAds as $ad)
                        @if($ad->size === '728x90')
                            <a href="{{ $ad->link_url }}" target="_blank">
                                <img src="{{ asset('storage/' . $ad->image_url) }}" 
                                     alt="{{ $ad->title }}" 
                                     style="max-width: 728px; height: 90px;">
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
            
            <!-- Navigation -->
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                        <i class="fas fa-newspaper"></i> News Portal
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news.index') }}">All News</a>
                            </li>
                            @if(isset($categories))
                                @foreach($categories->take(5) as $category)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('news.category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        
                        <!-- Search Form -->
                        <form class="d-flex" method="GET" action="{{ route('news.index') }}">
                            <input class="form-control me-2" type="search" name="search" 
                                   placeholder="Search news..." value="{{ request('search') }}">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <!-- Footer Ads -->
            @if(isset($footerAds) && $footerAds->count() > 0)
                <div class="ad-banner mb-4">
                    @foreach($footerAds as $ad)
                        @if($ad->size === '728x90')
                            <a href="{{ $ad->link_url }}" target="_blank">
                                <img src="{{ asset('storage/' . $ad->image_url) }}" 
                                     alt="{{ $ad->title }}" 
                                     style="max-width: 728px; height: 90px;">
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
            
            <div class="row">
                <div class="col-md-6">
                    <h5>News Portal</h5>
                    <p>Your trusted source for the latest news and updates.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} News Portal. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 