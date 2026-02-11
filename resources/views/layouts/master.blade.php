<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion Store')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
    <script>
        const baseUrl = "{{ url('/') }}";
    </script>
    @stack('styles')
</head>
<body class="bg-primary text-secondary font-sans">
    @include('partials.header')

<main>
    @yield('content')
</main>

@include('partials.footer')

@include('partials.cart-drawer')
@include('partials.login-modal')
@include('partials.signup-modal')

@include('partials.scripts')
</body>
</html>
