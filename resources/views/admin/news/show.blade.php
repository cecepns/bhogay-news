@extends('layouts.admin')

@section('title', 'View News - ' . $news->title)
@section('page-title', 'View News Article')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- News Details Card -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Article Details</h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Title and Status -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h3 class="mb-2">{{ $news->title }}</h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-link"></i> Slug: {{ $news->slug }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            @if($news->status === 'published')
                                <span class="badge bg-success fs-6">Published</span>
                            @else
                                <span class="badge bg-warning fs-6">Draft</span>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    @if($news->thumbnail)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $news->thumbnail) }}" 
                                 alt="{{ $news->title }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 300px; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="mb-4">
                        <h5>Content</h5>
                        <div class="border rounded p-3 bg-light">
                            {!! $news->content !!}
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Category</h6>
                            <p class="mb-3">
                                <span class="badge bg-secondary">{{ $news->category->name }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Views</h6>
                            <p class="mb-3">
                                <i class="fas fa-eye text-muted"></i> {{ number_format($news->views) }} views
                            </p>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Created</h6>
                            <p class="mb-3">
                                <i class="fas fa-calendar-plus text-muted"></i> 
                                {{ $news->created_at->format('F d, Y \a\t h:i A') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Last Updated</h6>
                            <p class="mb-3">
                                <i class="fas fa-calendar-edit text-muted"></i> 
                                {{ $news->updated_at->format('F d, Y \a\t h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Quick Actions Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Article
                        </a>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create New Article
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list"></i> All Articles
                        </a>
                    </div>
                </div>
            </div>

            <!-- Article Stats Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Article Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ number_format($news->views) }}</h4>
                                <small class="text-muted">Total Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <h4 class="text-success mb-1">{{ $news->status === 'published' ? 'Live' : 'Draft' }}</h4>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h6 class="text-muted mb-1">{{ $news->created_at->diffForHumans() }}</h6>
                                <small class="text-muted">Created</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <h6 class="text-muted mb-1">{{ $news->updated_at->diffForHumans() }}</h6>
                                <small class="text-muted">Updated</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this article? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('admin.news.destroy', $news) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Article</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // ANCHOR: Handle delete confirmation
    function confirmDelete() {
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }
</script>
@endsection 