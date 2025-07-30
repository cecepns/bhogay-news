@extends('layouts.admin')

@section('title', 'Edit News - ' . $news->title)
@section('page-title', 'Edit News Article')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Article</h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.news.show', $news) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $news->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Image</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" name="thumbnail" accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                            
                            <!-- Current Thumbnail Preview -->
                            @if($news->thumbnail)
                                <div class="mt-2">
                                    <label class="form-label">Current Thumbnail:</label>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $news->thumbnail) }}" 
                                             alt="Current thumbnail" 
                                             class="me-3" 
                                             style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px;">
                                        <div>
                                            <small class="text-muted d-block">{{ $news->thumbnail }}</small>
                                            <small class="text-muted">Upload new image to replace</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <input id="content" type="hidden" name="content" value="{{ old('content', $news->content) }}">
                            <trix-editor input="content" class="@error('content') is-invalid @enderror"></trix-editor>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news.show', $news) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update News
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Article Info Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Article Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Slug</small>
                        <div class="fw-bold">{{ $news->slug }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Views</small>
                        <div class="fw-bold">
                            <i class="fas fa-eye text-muted"></i> {{ number_format($news->views) }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Created</small>
                        <div class="fw-bold">{{ $news->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Last Updated</small>
                        <div class="fw-bold">{{ $news->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.news.show', $news) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Article
                        </a>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Create New Article
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-list"></i> All Articles
                        </a>
                    </div>
                </div>
            </div>

            <!-- Publishing Guidelines Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Editing Guidelines</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Review content before publishing
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Update thumbnail if needed
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Choose appropriate status
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Verify category selection
                        </li>
                    </ul>
                    
                    <div class="alert alert-warning mt-3">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i> 
                            Changes will be saved immediately when you click "Update News".
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // ANCHOR: Auto-update slug preview from title
    document.getElementById('title').addEventListener('input', function() {
        // This would be for slug preview if needed
        // For now, slug is auto-generated on the server side
    });
    
    // ANCHOR: Confirm before leaving with unsaved changes
    let formChanged = false;
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    
    form.addEventListener('submit', function() {
        formChanged = false;
    });
</script>
@endsection 