@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Category: {{ $category->name }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Brief description of what this category covers.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Category Slug</label>
                            <input type="text" class="form-control" value="{{ $category->slug }}" readonly>
                            <div class="form-text">Slug will be automatically generated from the category name.</div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Categories
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        <small class="text-muted">
                            {{ $category->created_at->format('M d, Y \a\t h:i A') }}
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">
                            {{ $category->updated_at->format('M d, Y \a\t h:i A') }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <strong>News Articles:</strong><br>
                        <span class="badge bg-primary">{{ $category->news_count ?? $category->news()->count() }} articles</span>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning"></i> 
                            Changing the name will update the slug
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning"></i> 
                            Keep category names clear and descriptive
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-lightbulb text-warning"></i> 
                            Avoid duplicate category names
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection 