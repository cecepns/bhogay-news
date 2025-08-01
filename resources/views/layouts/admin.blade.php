<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - News Portal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Trix Editor CSS -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">
                            <i class="fas fa-newspaper"></i> News Admin
                        </h5>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" 
                               href="{{ route('admin.news.index') }}">
                                <i class="fas fa-newspaper"></i> News
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                               href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-folder"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" 
                               href="{{ route('admin.tags.index') }}">
                                <i class="fas fa-tags"></i> Tags
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.ads.*') ? 'active' : '' }}" 
                               href="{{ route('admin.ads.index') }}">
                                <i class="fas fa-ad"></i> Advertisements
                            </a>
                        </li> -->
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-external-link-alt"></i> View Site
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div>
                        Welcome, {{ auth()->user()->name }}
                    </div>
                </div>

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Trix Editor JS -->
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    
    <!-- ANCHOR: Trix Attachment Handler -->
    <script>
        document.addEventListener('trix-attachment-add', function(event) {
            const attachment = event.attachment;
            const file = attachment.file;
            
            // Check if file is an image
            if (!file || !file.type.startsWith('image/')) {
                attachment.remove();
                alert('Only image files are allowed!');
                return;
            }
            
            // Check file size (2MB limit)
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            if (file.size > maxSize) {
                attachment.remove();
                alert('File size must be less than 2MB!');
                return;
            }
            
            // Upload the file
            const formData = new FormData();
            formData.append('attachment', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || 
                                     document.querySelector('input[name="_token"]')?.value);
            
            fetch('{{ route("admin.trix.attachment") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    attachment.remove();
                    alert('Upload failed: ' + data.error);
                } else {
                    attachment.setAttributes({
                        url: data.attachment.url,
                        href: data.attachment.url,
                        filename: data.attachment.filename,
                        filesize: data.attachment.filesize,
                        contentType: data.attachment.content_type
                    });
                }
            })
            .catch(error => {
                attachment.remove();
                console.error('Upload error:', error);
                alert('Upload failed. Please try again.');
            });
        });
        
        // Handle attachment removal
        document.addEventListener('trix-attachment-remove', function(event) {
            // Optional: You could add logic here to delete the file from server
            console.log('Attachment removed:', event.attachment);
        });
        
        // Disable file attachments that are not images
        document.addEventListener('trix-file-accept', function(event) {
            const file = event.file;
            if (!file.type.startsWith('image/')) {
                event.preventDefault();
                alert('Only image files are allowed!');
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html> 