@extends('layouts.admin')

@section('title', 'View Advertisement')
@section('page-title', 'View Advertisement')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Advertisement Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{ $ad->title }}</h4>
                            
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Size:</strong><br>
                                        <span class="badge bg-info">{{ $ad->size }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Position:</strong><br>
                                        <span class="badge bg-secondary">{{ ucfirst($ad->position) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>Status:</strong><br>
                                @if($ad->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning">Inactive</span>
                                @endif
                            </div>

                            @if($ad->link_url)
                                <div class="mb-3">
                                    <strong>Link URL:</strong><br>
                                    <a href="{{ $ad->link_url }}" target="_blank" class="text-decoration-none">
                                        {{ $ad->link_url }}
                                        <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Created:</strong><br>
                                        <small class="text-muted">{{ $ad->created_at->format('M d, Y \a\t h:i A') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <strong>Last Updated:</strong><br>
                                        <small class="text-muted">{{ $ad->updated_at->format('M d, Y \a\t h:i A') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            @if($ad->image_url)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $ad->image_url) }}" 
                                         alt="{{ $ad->title }}" 
                                         class="img-fluid rounded" 
                                         style="max-width: 100%; max-height: 200px; object-fit: contain;">
                                </div>
                            @else
                                <div class="text-center">
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                         style="width: 100%; height: 200px;">
                                        <i class="fas fa-image text-muted fa-3x"></i>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.ads.edit', $ad) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Advertisement
                        </a>
                        
                        <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this advertisement?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Advertisement
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Advertisements
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Advertisement Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID:</strong><br>
                        <small class="text-muted">{{ $ad->id }}</small>
                    </div>

                    <div class="mb-3">
                        <strong>Image Path:</strong><br>
                        <small class="text-muted">{{ $ad->image_url ?: 'No image uploaded' }}</small>
                    </div>

                    <div class="mb-3">
                        <strong>Size Dimensions:</strong><br>
                        <small class="text-muted">
                            @switch($ad->size)
                                @case('468x60')
                                    Banner (468×60 pixels)
                                    @break
                                @case('160x300')
                                    Sidebar (160×300 pixels)
                                    @break
                                @case('320x50')
                                    Mobile Banner (320×50 pixels)
                                    @break
                                @case('300x250')
                                    Medium Rectangle (300×250 pixels)
                                    @break
                                @case('160x600')
                                    Wide Skyscraper (160×600 pixels)
                                    @break
                                @case('728x90')
                                    Leaderboard (728×90 pixels)
                                    @break
                                @default
                                    {{ $ad->size }}
                            @endswitch
                        </small>
                    </div>

                    <div class="mb-3">
                        <strong>Position Description:</strong><br>
                        <small class="text-muted">
                            @switch($ad->position)
                                @case('header')
                                    Top of the page
                                    @break
                                @case('sidebar')
                                    Side navigation area
                                    @break
                                @case('footer')
                                    Bottom of the page
                                    @break
                                @case('content-top')
                                    Above main content
                                    @break
                                @case('content-bottom')
                                    Below main content
                                    @break
                                @default
                                    {{ ucfirst($ad->position) }}
                            @endswitch
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 