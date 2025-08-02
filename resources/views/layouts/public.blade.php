<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title', 'News Portal')</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome-5.0.8/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/util.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
<!--===============================================================================================-->
</head>
<body class="animsition">
	
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Header Mobile -->
			<div class="wrap-header-mobile">
				<!-- Logo mobile -->		
				<div class="logo-mobile">
					<a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="IMG-LOGO"></a>
				</div>

				<!-- Button show menu -->
				<div class="btn-show-menu-mobile hamburger hamburger--squeeze m-r--8">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>

			<!-- Menu Mobile -->
			<div class="menu-mobile">
				<ul class="main-menu-m">
					<li>
						<a href="index.html">Home</a>
					</li>

                    @foreach($topFiveCategories as $category)
                        <li>
                            <a href="{{ route('news.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
				</ul>
			</div>
			
			<!--  -->
			<div class="wrap-logo container">
				<!-- Logo desktop -->		
				<div class="logo">
					<a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="LOGO"></a>
				</div>	

				<div class="banner-header">
					@include('components.advertisement', ['size' => '728x90'])
				</div>
			</div>	
			
			<!--  -->
			<div class="wrap-main-nav">
				<div class="main-nav">
					<!-- Menu desktop -->
					<nav class="menu-desktop">
						<a class="logo-stick" href="{{ route('home') }}">
							<img src="{{ asset('images/logo.png') }}" alt="LOGO">
						</a>

						<ul class="main-menu">
							<li class="main-menu-active">
								<a href="{{ route('home') }}">Home</a>
							</li>
                            @foreach($topFiveCategories as $category)
                                <li>
                                    <a href="{{ route('news.index', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach
						</ul>
					</nav>
				</div>
			</div>	
		</div>
	</header>

    @yield('content')

	<!-- Footer -->
	@yield('footer')
	<footer>
		<div class="bg2 p-t-40 p-b-25">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 p-b-20">
						<div class="size-h-3 flex-s-c">
							<a href="{{ route('home') }}">
								<img class="max-s-full" src="{{ asset('images/logo-white.png') }}" alt="LOGO">
							</a>
						</div>

						<div>
							<p class="f1-s-1 cl11 p-b-16">
								{{ $siteName }} is your trusted source for the latest news, insightful articles, and trending stories from around the world. Stay informed with our up-to-date coverage and in-depth analysis on topics that matter to you.
							</p>
						</div>

                            <div >
							@include('components.advertisement', ['size' => '320x50'])
                            </div>
					</div>

					<div class="col-sm-6 col-lg-4 p-b-20">
						<div class="size-h-3 flex-s-c">
							<h5 class="f1-m-7 cl0">
								Popular Posts
							</h5>
						</div>

						<ul>
							@if(isset($mostViewedNewsFooter) && $mostViewedNewsFooter->count() > 0)
								@foreach($mostViewedNewsFooter as $news)
									<li class="flex-wr-sb-s p-b-20">
										<a href="{{ route('news.show', $news->slug) }}" class="size-w-4 wrap-pic-w hov1 trans-03">
											<img src="{{ $news->thumbnail ? asset('storage/' . $news->thumbnail) : 'https://placehold.co/100x100/E8E8E8/A7A6A6.png?text=News' }}" alt="{{ $news->title }}">
										</a>

										<div class="size-w-5">
											<h6 class="p-b-5">
												<a href="{{ route('news.show', $news->slug) }}" class="f1-s-5 cl11 hov-cl10 trans-03">
													{{ Str::limit($news->title, 50) }}
												</a>
											</h6>

											<span class="f1-s-3 cl6">
												{{ $news->created_at->format('M d') }}
											</span>
										</div>
									</li>
								@endforeach
							@else
								<li class="flex-wr-sb-s p-b-20">
									<div class="size-w-5">
										<span class="f1-s-3 cl6">No popular posts available</span>
									</div>
								</li>
							@endif
						</ul>
					</div>

					<div class="col-sm-6 col-lg-4 p-b-20">
						<div class="size-h-3 flex-s-c">
							<h5 class="f1-m-7 cl0">
								Category
							</h5>
						</div>

						<ul class="m-t--12">
							@if(isset($topFiveCategories) && $topFiveCategories->count() > 0)
								@foreach($topFiveCategories as $category)
									<li class="how-bor1 p-rl-5 p-tb-10">
										<a href="{{ route('news.index', ['category' => $category->slug]) }}" class="f1-s-5 cl11 hov-cl10 trans-03 p-tb-8">
											{{ $category->name }} ({{ $category->published_news_count }})
										</a>
									</li>
								@endforeach
							@else
								<li class="how-bor1 p-rl-5 p-tb-10">
									<span class="f1-s-5 cl11 p-tb-8">No categories available</span>
								</li>
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="bg11">
			<div class="container size-h-4 flex-c-c p-tb-15">
				<span class="f1-s-1 cl0 txt-center">
					Copyright © {{ $currentYear }} {{ $siteName }}. All rights reserved.
				</span>
			</div>
		</div>
	</footer>

	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<span class="fas fa-angle-up"></span>
		</span>
	</div>

<!--===============================================================================================-->	
	<script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('js/main.js') }}"></script>

	@include('components.advertisement', ['size' => 'no-size'])
</body>
</html>