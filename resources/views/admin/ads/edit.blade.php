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
                            <label for="script" class="form-label">Advertisement Script</label>
                            <textarea class="form-control @error('script') is-invalid @enderror" 
                                      id="script" name="script" rows="8" 
                                      placeholder="Paste your advertisement script here...">{{ old('script', $ad->script) }}</textarea>
                            @error('script')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Paste the complete advertisement script including any configuration options. Leave empty if no script available.</div>
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
                        <strong>Script Length:</strong><br>
                        @if($ad->script)
                            <small class="text-muted">{{ strlen($ad->script) }} characters</small>
                        @else
                            <small class="text-muted"><em>No script available</em></small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 