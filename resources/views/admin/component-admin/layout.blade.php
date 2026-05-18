<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Thư Viện Số')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Admin CSS -->
    @vite('resources/css/admin.css')

    <!-- Page-specific CSS -->
    @stack('styles')
</head>

<body>
    <div class="admin-wrapper">
    <!-- Sidebar -->
    @include('admin.component-admin.sidebar')

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Header -->
        @include('admin.component-admin.header')

        <!-- Content -->
        <main class="admin-content p-4">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('admin.component-admin.footer')
    </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin JS -->
    @vite('resources/js/admin.js')

    <!-- Page-specific JS -->
    @stack('scripts')
</body>

</html>
