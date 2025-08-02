@extends('layouts.public')

@section('title', 'Home - News Portal')
@section('description', 'Latest news and updates from around the world')

@section('content')
	<!-- Headline -->
	<div class="container">
		<div class="bg0 flex-wr-sb-c p-rl-20 p-tb-8">
			<div class="f2-s-1 p-r-30 size-w-0 m-tb-6 flex-wr-s-c">
				<span class="text-uppercase cl2 p-r-8">
					Featured News
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
		
	<!-- Feature post -->
	<section class="bg0">
		<div class="container">
			<div class="row m-rl--1">
				@if($featuredNews->count() > 0)
					<div class="col-md-6 p-rl-1 p-b-2">
						<div class="bg-img1 size-a-3 how1 pos-relative" style="background-image: url({{ $featuredNews->first()->thumbnail ?? 'https://placehold.co/600x400/E8E8E8/A7A6A6.png?text=Post+Thumbnail' }});">
							<a href="{{ route('news.show', $featuredNews->first()->slug) }}" class="dis-block how1-child1 trans-03"></a>

							<div class="flex-col-e-s s-full p-rl-25 p-tb-20">
								<a href="{{ route('news.index', ['category' => $featuredNews->first()->category->slug]) }}" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
									{{ $featuredNews->first()->category->name }}
								</a>

								<h3 class="how1-child2 m-t-14 m-b-10">
									<a href="{{ route('news.show', $featuredNews->first()->slug) }}" class="how-txt1 size-a-6 f1-l-1 cl0 hov-cl10 trans-03">
										{{ $featuredNews->first()->title }}
									</a>
								</h3>

								<span class="how1-child2">
									<span class="f1-s-4 cl11">
										{{ $featuredNews->first()->author ?? 'Admin' }}
									</span>

									<span class="f1-s-3 cl11 m-rl-3">
										-
									</span>

									<span class="f1-s-3 cl11">
										{{ $featuredNews->first()->created_at->format('M d') }}
									</span>
								</span>
							</div>
						</div>
					</div>

					<div class="col-md-6 p-rl-1">
						<div class="row m-rl--1">
							@if($featuredNews->count() > 1)	
								<div class="col-12 p-rl-1 p-b-2">
									<div class="bg-img1 size-a-4 how1 pos-relative" style="background-image: url({{ $featuredNews[1]->thumbnail ?? 'https://placehold.co/600x400/E8E8E8/A7A6A6.png?text=Post+Thumbnail' }});">
										<a href="{{ route('news.show', $featuredNews[1]->slug) }}" class="dis-block how1-child1 trans-03"></a>

										<div class="flex-col-e-s s-full p-rl-25 p-tb-24">
											<a href="{{ route('news.index', ['category' => $featuredNews[1]->category->slug]) }}" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
												{{ $featuredNews[1]->category->name }}
											</a>

											<h3 class="how1-child2 m-t-14">
												<a href="{{ route('news.show', $featuredNews[1]->slug) }}" class="how-txt1 size-a-7 f1-l-2 cl0 hov-cl10 trans-03">
													{{ $featuredNews[1]->title }}
												</a>
											</h3>
										</div>
									</div>
								</div>
							@endif

							@if($featuredNews->count() > 2)
								<div class="col-sm-6 p-rl-1 p-b-2">
									<div class="bg-img1 size-a-5 how1 pos-relative" style="background-image: url({{ $featuredNews[2]->thumbnail ?? 'https://placehold.co/600x400/E8E8E8/A7A6A6.png?text=Post+Thumbnail' }});">
										<a href="{{ route('news.show', $featuredNews[2]->slug) }}" class="dis-block how1-child1 trans-03"></a>

										<div class="flex-col-e-s s-full p-rl-25 p-tb-20">
											<a href="{{ route('news.index', ['category' => $featuredNews[2]->category->slug]) }}" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
												{{ $featuredNews[2]->category->name }}
											</a>

											<h3 class="how1-child2 m-t-14">
												<a href="{{ route('news.show', $featuredNews[2]->slug) }}" class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
													{{ $featuredNews[2]->title }}
												</a>
											</h3>
										</div>
									</div>
								</div>
							@endif

							@if($featuredNews->count() > 3)
								<div class="col-sm-6 p-rl-1 p-b-2">
										<div class="bg-img1 size-a-5 how1 pos-relative" style="background-image: url({{ $featuredNews[3]->thumbnail ?? 'https://placehold.co/600x400/E8E8E8/A7A6A6.png?text=Post+Thumbnail' }});">
										<a href="{{ route('news.show', $featuredNews[3]->slug) }}" class="dis-block how1-child1 trans-03"></a>

										<div class="flex-col-e-s s-full p-rl-25 p-tb-20">
											<a href="{{ route('news.index', ['category' => $featuredNews[3]->category->slug]) }}" class="dis-block how1-child2 f1-s-2 cl0 bo-all-1 bocl0 hov-btn1 trans-03 p-rl-5 p-t-2">
												{{ $featuredNews[3]->category->name }}
											</a>

											<h3 class="how1-child2 m-t-14">
												<a href="{{ route('news.show', $featuredNews[3]->slug) }}" class="how-txt1 size-h-1 f1-m-1 cl0 hov-cl10 trans-03">
													{{ $featuredNews[3]->title }}
												</a>
											</h3>
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>
				@else
					<!-- Fallback content when no featured news -->
					<div class="col-12 text-center p-t-50 p-b-50">
						<h3 class="f1-m-2 cl3">No featured news available</h3>
						<p class="f1-s-1 cl6">Check back later for the latest updates.</p>
					</div>
				@endif
			</div>
		</div>
	</section>

	<!-- Post -->
	<section class="bg0 p-t-70">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10 col-lg-8">
					<div class="p-b-20">
						<div class="tab01 p-b-20">
							<div class="tab01-head how2 how2-cl1 bocl12 d-flex justify-content-between align-items-center m-r-10 m-r-0-sr991">
								<h3 class="f1-m-2 cl12 tab01-title mb-0">
									Latest News
								</h3>
								<a href="{{ route('news.index') }}" class="tab01-link f1-s-1 cl9 hov-cl10 trans-03">
									View all
									<i class="fs-12 m-l-5 fa fa-caret-right"></i>
								</a>
							</div>
								

							<div class="row p-t-35">
								@foreach($latestNews as $news)
								<div class="col-sm-6 p-r-25 p-r-15-sr991">
									<!-- Item latest -->	
									<div class="m-b-45">
										<a href="{{ route('news.show', $news->slug) }}" class="wrap-pic-w hov1 trans-03">
											<img src="{{ $news->thumbnail ?? 'https://placehold.co/600x400/E8E8E8/A7A6A6.png?text=Post+Thumbnail' }}" alt="{{ $news->title }}">
										</a>

										<div class="p-t-16">
											<h5 class="p-b-5">
												<a href="{{ route('news.show', $news->slug) }}" class="f1-m-3 cl2 hov-cl10 trans-03">
													{{ $news->title }}
												</a>
											</h5>

											<span class="cl8">
												<a href="#" class="f1-s-4 cl8 hov-cl10 trans-03">
													by {{ $news->author ?? 'Admin' }}
												</a>

												<span class="f1-s-3 m-rl-3">
													-
												</span>

												<span class="f1-s-3">
													{{ $news->created_at->format('M d') }}
												</span>
											</span>
										</div>
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-10 col-lg-4">
					<div class="p-l-10 p-rl-0-sr991 p-b-20">
						<!-- Most Popular News -->
						<div>
							<div class="how2 how2-cl4 flex-s-c">
								<h3 class="f1-m-2 cl3 tab01-title">
									Most Popular
								</h3>
							</div>

							@if($mostViewedNews->count() > 0)
								<ul class="p-t-35">
									@foreach($mostViewedNews as $index => $news)
										<li class="flex-wr-sb-s p-b-22">
											<div class="size-a-8 flex-c-c borad-3 size-a-8 bg9 f1-m-4 cl0 m-b-6">
												{{ $index + 1 }}
											</div>

											<a href="{{ route('news.show', $news->slug) }}" class="size-w-3 f1-s-7 cl3 hov-cl10 trans-03">
												{{ $news->title }}
											</a>
										</li>
									@endforeach
								</ul>
							@else
								<div class="p-t-35 text-center">
									<p class="f1-s-1 cl6">No popular news available</p>
								</div>
							@endif
						</div>
					</div>
					<div class="p-b-55">
						<div class="how2 how2-cl4 flex-s-c m-b-30">
							<h3 class="f1-m-2 cl3 tab01-title">
								Tags
							</h3>
						</div>

						<div class="flex-wr-s-s m-rl--5">
							@forelse($tags as $tag)
								<a href="{{ route('news.byTag', $tag->slug) }}" class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
									{{ $tag->name }}
								</a>
							@empty
								<span class="f1-s-1 cl6">No tags available</span>
							@endforelse
						</div>	
					</div>

					
					<div class="p-b-55">
						@include('components.advertisement', ['size' => '300x250'])
					</div>

					<div class="p-b-55">
						<div class="how2 how2-cl4 flex-s-c m-b-30">
							<h3 class="f1-m-2 cl3 tab01-title">
								Categories
							</h3>
						</div>

						<div class="flex-wr-s-s m-rl--5">
							@forelse($categories as $category)
								<a href="{{ route('news.index', ['category' => $category->slug]) }}" class="flex-c-c size-h-2 bo-1-rad-20 bocl12 f1-s-1 cl8 hov-btn2 trans-03 p-rl-20 p-tb-5 m-all-5">
									{{ $category->name }}
								</a>
							@empty
								<span class="f1-s-1 cl6">No categories available</span>
							@endforelse
						</div>	
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection 