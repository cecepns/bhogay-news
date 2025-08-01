@extends('layouts.admin')

@section('title', 'Tambah Tag')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3">Tambah Tag</h1>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Tag <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nama tag akan otomatis diubah menjadi slug.</div>
                        </div>

                        <div class="mb-3">
                            <h6>Preview Tag:</h6>
                            <span id="tag-preview" class="badge bg-primary">
                                Tag Preview
                            </span>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Tag
                            </button>
                            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const preview = document.getElementById('tag-preview');

    function updatePreview() {
        const name = nameInput.value || 'Tag Preview';
        preview.textContent = name;
    }

    nameInput.addEventListener('input', updatePreview);
    
    // Initial preview
    updatePreview();
});
</script>
@endsection