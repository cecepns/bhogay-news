@extends('layouts.admin')

@section('title', 'Detail Tag: ' . $tag->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Detail Tag: {{ $tag->name }}</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informasi Tag</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="fw-bold">Nama:</label>
                                <div>
                                    <span class="badge bg-primary" style="font-size: 0.9em;">
                                        {{ $tag->name }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Slug:</label>
                                <div class="text-muted">{{ $tag->slug }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Total Berita:</label>
                                <div>
                                    <span class="badge bg-info">{{ $tag->news->count() }} berita</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Dibuat:</label>
                                <div class="text-muted">{{ $tag->created_at->format('d M Y, H:i') }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Terakhir Diupdate:</label>
                                <div class="text-muted">{{ $tag->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Berita dengan Tag ini</h5>
                        </div>
                        <div class="card-body">
                            @if($tag->news->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Kategori</th>
                                                <th>Status</th>
                                                <th>Views</th>
                                                <th>Tanggal</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tag->news as $news)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.news.show', $news) }}" class="text-decoration-none">
                                                            {{ Str::limit($news->title, 50) }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $news->category->name }}</span>
                                                    </td>
                                                    <td>
                                                        @if($news->status === 'published')
                                                            <span class="badge bg-success">Published</span>
                                                        @else
                                                            <span class="badge bg-warning">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ number_format($news->views) }} views</small>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $news->created_at->format('d M Y') }}</small>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.news.show', $news) }}" 
                                                               class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.news.edit', $news) }}" 
                                                               class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($tag->news->count() === 10)
                                    <div class="text-center mt-3">
                                        <small class="text-muted">Menampilkan 10 berita terbaru. 
                                            <a href="{{ route('admin.news.index') }}?tag={{ $tag->slug }}">Lihat semua berita dengan tag ini</a>
                                        </small>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-newspaper fa-3x mb-3"></i>
                                        <p>Belum ada berita dengan tag ini.</p>
                                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Buat Berita Baru
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection