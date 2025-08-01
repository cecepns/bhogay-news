@extends('layouts.admin')

@section('title', 'Edit Advertisement')
@section('page-title', 'Edit Advertisement')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Advertisement</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.ads.update', $ad) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $ad->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Advertisement Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to keep the current image. Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                            
                            @if($ad->image_url)
                                <div class="mt-2">
                                    <label class="form-label">Current Image:</label>
                                    <div>
                                        <img src="{{ asset('storage/' . $ad->image_url) }}" 
                                             alt="{{ $ad->title }}" 
                                             class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 150px;">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="link_url" class="form-label">Link URL</label>
                            <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                   id="link_url" name="link_url" value="{{ old('link_url', $ad->link_url) }}" 
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
                                            <option value="{{ $size }}" {{ old('size', $ad->size) == $size ? 'selected' : '' }}>
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
                                            <option value="{{ $position }}" {{ old('position', $ad->position) == $position ? 'selected' : '' }}>
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
                                       {{ old('is_active', $ad->is_active) ? 'checked' : '' }}>
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
                                <i class="fas fa-save"></i> Update Advertisement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Advertisement Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $ad->created_at->format('M d, Y \a\t h:i A') }}</small>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">{{ $ad->updated_at->format('M d, Y \a\t h:i A') }}</small>
                    </div>

                    <div class="mb-3">
                        <strong>Current Status:</strong><br>
                        @if($ad->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong>Current Size:</strong><br>
                        <span class="badge bg-info">{{ $ad->size }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>Current Position:</strong><br>
                        <span class="badge bg-secondary">{{ ucfirst($ad->position) }}</span>
                    </div>

                    @if($ad->link_url)
                        <div class="mb-3">
                            <strong>Link URL:</strong><br>
                            <small class="text-muted">{{ $ad->link_url }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 