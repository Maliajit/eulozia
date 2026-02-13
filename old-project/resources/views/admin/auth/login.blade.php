@php
/**
 * Admin Login Page
 * 
 * Purpose: Primary entry point for admin dashboard access.
 * 
 * Data Flow: 
 * - Input: Email and Password.
 * - Submission: POST to `admin.login.submit`.
 * - Feedback: Displays validation errors or SweetAlert2 success messages.
 * 
 * Database: 
 * - `admins`: Validates user credentials.
 * 
 * Dependencies: Tailwind CSS, FontAwesome, SweetAlert2.
 */
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Universal Admin Theme (Single CSS File) -->
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

    <style>
        /* Small overrides or page-specific tweaks if necessary */
    </style>
</head>

<body class="login-body">
    <div class="login-card">
        <!-- Logo Header -->
        <div class="login-header">
            <div class="admin-logo-box login-size mx-auto mb-4">
                <i class="fas fa-store"></i>
            </div>
            <h1 class="login-title">
                {{ config('app.name', 'Laravel Admin') }}
            </h1>
            <p class="text-gray-600">Sign in to your admin dashboard</p>
        </div>

        <!-- Login Form -->
        <div class="login-content">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-700 font-medium">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-6">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2"></i>Email
                    </label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1  focus:border-transparent"
                        placeholder="Enter your email" autocomplete="email" autofocus value="{{ old('email') }}">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-1  focus:border-transparent"
                        placeholder="Enter your password" autocomplete="current-password">
                </div>

                {{-- <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-5 h-5 border-2 border-gray-300 rounded checked:bg-indigo-500 checked:border-indigo-500 mr-2"
                               id="remember">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div> --}}

                <button type="submit" class="btn-primary w-full py-3 text-lg font-medium">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">
                © {{ date('Y') }} eCommerce Admin Panel
            </p>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
</body>

</html>
