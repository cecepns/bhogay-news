@extends('layouts.admin')

@section('title', 'Create News')
@section('page-title', 'Create News')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Create New Article</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
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
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                        <label for="addTags" class="form-label">Tags</label>
                        <input class="form-control" type="text" id="addTags" placeholder="Ketik tag dan tekan Enter untuk menambahkan">
                            <div class="form-text">
                                <p class="text-muted mt-2">
                                    Saran tags: 
                                    @foreach($tags->take(5) as $tag)
                                        <span 
                                            class="badge bg-light text-dark me-1 tag-suggestion" 
                                            data-tag="{{ $tag->name }}" 
                                            style="cursor: pointer; transition: all 0.2s;"
                                            onmouseover="this.style.backgroundColor='#007bff'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='#f8f9fa'; this.style.color='#212529';">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </p>
                            </div>
                            
                            <!-- Tag Preview -->
                            <div id="selected-tags" class="mt-2"></div>
                            <input type="hidden" hidden id="tags" name="tags" value="{{ old('tags') }}">
                        </div>

                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Image</label>
                            <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" name="thumbnail" accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content" class="@error('content') is-invalid @enderror"></trix-editor>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to News
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create News
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Publishing Guidelines</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Write compelling headlines
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Add high-quality images
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Select appropriate category
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Add relevant tags
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success"></i> 
                            Use draft status for review
                        </li>
                    </ul>
                    
                    <div class="alert alert-info mt-3">
                        <small>
                            <i class="fas fa-info-circle"></i> 
                            Draft articles won't appear on the public site until published.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Trix Editor JS -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    
    <script>
        // Configure Trix for file attachments
        document.addEventListener("trix-attachment-add", function(event) {
            handleTrixAttachment(event);
        });

        function handleTrixAttachment(event) {
            var attachment = event.attachment;
            
            if (attachment.file) {
                var formData = new FormData();
                formData.append("Content-Type", attachment.file.type);
                formData.append("attachment", attachment.file);
                formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                fetch("{{ route('admin.trix.attachment') }}", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        attachment.setAttributes({
                            url: data.url,
                            href: data.url
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        // Tags input functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tagsInput = document.getElementById('addTags');
            const tagsHiddenInput = document.getElementById('tags');
            const selectedTagsDiv = document.getElementById('selected-tags');
            const existingTags = @json($tags->pluck('name')->toArray());
            let selectedTags = [];

            function updateSelectedTags() {
                selectedTagsDiv.innerHTML = '';
                
                if (selectedTags.length > 0) {
                    const label = document.createElement('small');
                    label.textContent = 'Selected tags:';
                    label.className = 'text-muted d-block mb-2';
                    selectedTagsDiv.appendChild(label);
                    
                    selectedTags.forEach((tag, index) => {
                        const badge = document.createElement('span');
                        badge.className = 'badge bg-primary me-1 mb-1';
                        badge.innerHTML = tag + ' <i class="fas fa-times" style="cursor: pointer; margin-left: 5px;" onclick="removeTag(' + index + ')"></i>';
                        selectedTagsDiv.appendChild(badge);
                    });
                }
            }

            // Add tag function
            function addTag(tagName) {
                tagName = tagName.trim();
                if (tagName && !selectedTags.includes(tagName)) {
                    selectedTags.push(tagName);
                    updateSelectedTags();
                    updateHiddenInput();
                }
            }

            // Remove tag function (global)
            window.removeTag = function(index) {
                selectedTags.splice(index, 1);
                updateSelectedTags();
                updateHiddenInput();
                tagsInput.value = '';
            }

            // Update hidden input for form submission
            function updateHiddenInput() {
                tagsHiddenInput.value = selectedTags.join(', ');
            }

            // Handle Enter key to add tag
            tagsInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const currentValue = this.value.trim();
                    if (currentValue) {
                        const tags = currentValue.split(',').map(tag => tag.trim()).filter(tag => tag.length > 0);
                        tags.forEach(tag => addTag(tag));
                        this.value = '';
                    }
                }
            });

            // Handle tag suggestions click
            document.querySelectorAll('.tag-suggestion').forEach(suggestion => {
                suggestion.addEventListener('click', function() {
                    const tagName = this.getAttribute('data-tag');
                    addTag(tagName);
                    tagsInput.value = '';
                });
            });

            // Initial update
            updateSelectedTags();
        });
    </script>
@endsection 