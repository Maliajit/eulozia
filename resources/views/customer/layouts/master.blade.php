<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion Store')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script>
        // Global Axios Configuration
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        } else {
            console.error('CSRF token not found');
        }
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#FFFFFF',
                        accent: '#D1D5DB',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <script>
        const baseUrl = "{{ url('/') }}";
    </script>
    @stack('styles')
</head>

<body class="bg-primary text-secondary font-sans">
    @include('customer.partials.header')

    <main>
        @yield('content')
    </main>

    @include('customer.partials.footer')

    @include('customer.partials.cart-drawer')
    @include('customer.partials.login-modal')
    @include('customer.partials.signup-modal')

    @include('customer.partials.scripts')
    <script>
        function slide(btn, direction) {
            const track = btn.parentElement.querySelector('.carousel-track');
            const slides = track.querySelectorAll('.carousel-slide');
            let current = parseInt(track.getAttribute('data-current')) || 0;

            current += direction;

            if (current >= slides.length) current = 0;
            if (current < 0) current = slides.length - 1;

            track.style.transform = `translateX(-${current * 100}%)`;
            track.setAttribute('data-current', current);
        }
    </script>
</body>

</html>