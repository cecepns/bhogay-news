@extends('layouts.admin')

@section('title', 'Create Advertisement')
@section('page-title', 'Create Advertisement')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Advertisement</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.ads.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Advertisement Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                        </div>

                        <div class="mb-3">
                            <label for="link_url" class="form-label">Link URL</label>
                            <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                   id="link_url" name="link_url" value="{{ old('link_url') }}" 
                                   placeholder="https://example.com">
                            @error('link_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional. Where users will be redirected when they click the ad.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="size" class="form-label">Size <span class="text-danger">*</span></label>
                                    <select class="form-select @error('size') is-invalid @enderror" 
                                            id="size" name="size" required>
                                        <option value="">Select Size</option>
                                        @foreach($sizes as $size)
                                            <option value="{{ $size }}" {{ old('size') == $size ? 'selected' : '' }}>
                                                {{ $size }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                    <select class="form-select @error('position') is-invalid @enderror" 
                                            id="position" name="position" required>
                                        <option value="">Select Position</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position }}" {{ old('position') == $position ? 'selected' : '' }}>
                                                {{ ucfirst($position) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                       type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Advertisement
                                </label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Check this to make the advertisement visible on the website.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Advertisements
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Advertisement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Advertisement Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6>Image Requirements:</h6>
                        <ul class="small text-muted">
                            <li>High quality, clear images</li>
                            <li>Appropriate size for selected dimensions</li>
                            <li>Professional appearance</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6>Size Guidelines:</h6>
                        <ul class="small text-muted">
                            <li><strong>468x60:</strong> Banner ads</li>
                            <li><strong>160x300:</strong> Sidebar ads</li>
                            <li><strong>320x50:</strong> Mobile banner</li>
                            <li><strong>300x250:</strong> Medium rectangle</li>
                            <li><strong>160x600:</strong> Wide skyscraper</li>
                            <li><strong>728x90:</strong> Leaderboard</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <h6>Position Options:</h6>
                        <ul class="small text-muted">
                            <li><strong>Header:</strong> Top of the page</li>
                            <li><strong>Sidebar:</strong> Side navigation area</li>
                            <li><strong>Footer:</strong> Bottom of the page</li>
                            <li><strong>Content-top:</strong> Above main content</li>
                            <li><strong>Content-bottom:</strong> Below main content</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 