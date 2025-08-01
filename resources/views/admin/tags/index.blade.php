@extends('layouts.admin')

@section('title', 'Manajemen Tags')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Manajemen Tags</h1>
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Tag
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Slug</th>
                                    <th>Total Berita</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tags as $tag)
                                    <tr>
                                        <td>{{ $loop->iteration + (($tags->currentPage() - 1) * $tags->perPage()) }}</td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ $tag->name }}
                                            </span>
                                        </td>
                                        <td>{{ $tag->slug }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $tag->news_count }} berita</span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.tags.show', $tag) }}" 
                                                   class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.tags.edit', $tag) }}" 
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.tags.destroy', $tag) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus tag ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-tags fa-3x mb-3"></i>
                                                <p>Belum ada tag yang dibuat.</p>
                                                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                                                    Buat Tag Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($tags->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $tags->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection