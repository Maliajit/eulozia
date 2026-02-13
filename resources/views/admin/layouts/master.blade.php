@php
/**
 * Admin Master Layout
 * 
 * Purpose: This is the root layout for all admin-side pages. It includes metadata, 
 * common CSS/JS assets, and defines the structural framework (Sidebar, Header, Main Content).
 * 
 * Data Flow: 
 * - Injects project branding (title, logo) from app config.
 * - Yields 'content' from child views.
 * - Yields 'title' for SEO and browser tab naming.
 * - Passes CSRF token for all AJAX requests.
 * 
 * Database: N/A (Layout level)
 * Dependencies: Tailwind CSS (CDN), FontAwesome, Tabulator, Chart.js, SweetAlert2, Toastr.
 */
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel Admin'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Branding Meta -->
    <link rel="icon" type="image/x-icon" href="{{ asset(config('app.favicon', 'favicon.ico')) }}">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SortableJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <!-- Tabulator CSS -->
    <link href="https://unpkg.com/tabulator-tables@5.5.2/dist/css/tabulator.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Universal Admin Theme (Single CSS File) -->
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">



    <script>
        // Global variables
        const BASE_URL = '{{ url('/') }}';
        const ADMIN_URL = '{{ url('/admin') }}';
        const ASSET_URL = '{{ asset('') }}';
    </script>
</head>

<body class="bg-gray-50">
    @if (request()->is('admin/*') && !request()->is('admin/login'))
        @include('admin.partials.sidebar')
    @endif

    <div id="main-content" class="transition-all duration-300 @if (request()->is('admin/*') && !request()->is('admin/login')) ml-0 md:ml-24 @endif">
        @if (request()->is('admin/*') && !request()->is('admin/login'))
            @include('admin.partials.header')
        @endif

        <main class="@if (request()->is('admin/*') && !request()->is('admin/login')) p-4 sm:p-6 md:p-8 @endif">
            @yield('content')
        </main>
    </div>

    <!-- Common Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- Tabulator JS -->
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.2/dist/js/tabulator.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="{{ asset('js/admin/custom.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js"></script>
    <script>
        const token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found');
        }
    </script>





    @if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.success("{{ session('success') }}");
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toastr.error("{{ session('error') }}");
        });
    </script>
    @endif

    @stack('scripts')
</body>

</html>
