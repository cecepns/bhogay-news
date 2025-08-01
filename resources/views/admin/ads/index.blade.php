@extends('layouts.admin')

@section('title', 'Manage Advertisements')
@section('page-title', 'Advertisements Management')

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Advertisement
            </a>
        </div>
        <div class="col-md-6">
            <form method="GET" class="d-flex">
                <input type="text" class="form-control me-2" name="search" 
                       placeholder="Search ads..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Advertisements ({{ $ads->total() }})</h5>
        </div>
        <div class="card-body">
            @if($ads->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Size</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ads as $ad)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ Str::limit($ad->title, 50) }}</h6>
                                            @if($ad->link_url)
                                                <small class="text-muted">
                                                    <i class="fas fa-link"></i> {{ Str::limit($ad->link_url, 30) }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($ad->image_url)
                                            <img src="{{ asset('storage/' . $ad->image_url) }}" 
                                                 alt="{{ $ad->title }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 80px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 60px; border-radius: 5px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $ad->size }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $ad->position }}</span>
                                    </td>
                                    <td>
                                        @if($ad->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ $ad->created_at->format('M d, Y') }}<br>
                                            {{ $ad->created_at->format('h:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.ads.show', $ad) }}" 
                                               class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.ads.edit', $ad) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.ads.destroy', $ad) }}" 
                                                  class="d-inline" onsubmit="return confirm('Are you sure you want to delete this advertisement?')">
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
                    {{ $ads->links('vendor.pagination.custom') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-ad fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No advertisements found</h5>
                    <p class="text-muted mb-4">Start by creating your first advertisement.</p>
                    <a href="{{ route('admin.ads.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create First Advertisement
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection 