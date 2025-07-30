@extends('layouts.admin')

@section('title', 'Manage News')
@section('page-title', 'News Management')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Article
            </a>
        </div>
        <div class="col-md-6">
            <form method="GET" class="d-flex">
                <input type="text" class="form-control me-2" name="search" 
                       placeholder="Search news..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All News Articles ({{ $news->total() }})</h5>
        </div>
        <div class="card-body">
            @if($news->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $article)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($article->thumbnail)
                                                <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                                     alt="{{ $article->title }}" 
                                                     class="me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                            @else
                                                <div class="me-3 bg-light d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px; border-radius: 5px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ Str::limit($article->title, 50) }}</h6>
                                                <small class="text-muted">{{ $article->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $article->category->name }}</span>
                                    </td>
                                    <td>
                                        @if($article->status === 'published')
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="fas fa-eye text-muted"></i> {{ number_format($article->views) }}
                                    </td>
                                    <td>
                                        <small>
                                            {{ $article->created_at->format('M d, Y') }}<br>
                                            {{ $article->created_at->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.news.show', $article) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.news.edit', $article) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.news.destroy', $article) }}" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No news articles found</h5>
                    <p class="text-muted mb-4">Start by creating your first news article.</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create First Article
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection 