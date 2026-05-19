<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Thư Viện Số')</title>
    <meta name="description" content="Thư viện sách trực tuyến hàng đầu Việt Nam">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/sample logo 1.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Shared CSS -->
    @vite('resources/css/style.css')

    <!-- Page-specific CSS -->
    @stack('styles')
    
    <!-- Global utilities - MUST be first -->
    <script>
        // Setup CSRF token for all AJAX requests BEFORE any other scripts
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Override fetch to automatically add CSRF token
        const originalFetch = window.fetch;
        window.fetch = async function(url, options = {}) {
            if (typeof url === 'string' && (url.startsWith('/') || url.startsWith(window.location.origin))) {
                options.headers = {
                    ...options.headers,
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                };
            }
            return originalFetch(url, options);
        };
    </script>
</head>

<body>

    @yield('content')

    <!-- Back to Top Button -->
    <button id="backToTop" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4" style="display: none; z-index: 1000;">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Shared JS -->
    @vite('resources/js/script.js')

    <!-- Back to top functionality -->
    <script>
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTop');
            if (btn) {
                btn.style.display = window.scrollY > 300 ? 'block' : 'none';
            }
        });

        document.getElementById('backToTop')?.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    <!-- Page-specific JS -->
    @stack('scripts')

</body>

</html>
