@php
/**
 * Admin Login Page
 * 
 * Purpose: Primary entry point for admin dashboard access.
 * 
 * Features:
 * - Fully responsive layout optimized for mobile, tablet, and desktop.
 * - Premium modern glassmorphism aesthetic with high-fidelity gradients and hover interactions.
 * - Password visibility toggle.
 * - Integrated validation, error feedback, and SweetAlert2 notifications.
 */
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In - {{ config('app.name', 'Eulozia') }}</title>

    <!-- Branding Meta -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Universal Admin Theme (Loaded for branding variables) -->
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        /* Custom Premium CSS Effects */
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                        radial-gradient(circle at 90% 80%, rgba(147, 51, 234, 0.15) 0%, transparent 40%),
                        #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glow Blobs */
        .glow-blob {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #9333ea 100%);
            filter: blur(100px);
            opacity: 0.25;
            z-index: 0;
            pointer-events: none;
            animation: pulse-glow 10s infinite alternate;
        }

        .glow-blob-1 {
            top: 10%;
            left: 5%;
        }

        .glow-blob-2 {
            bottom: 10%;
            right: 5%;
            animation-delay: 3s;
        }

        @keyframes pulse-glow {
            0% { transform: scale(1) translate(0px, 0px); opacity: 0.2; }
            100% { transform: scale(1.2) translate(20px, -20px); opacity: 0.35; }
        }

        /* Glassmorphism Card Container */
        .glass-login-card {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            z-index: 10;
        }

        /* Custom Form Input Glow */
        .custom-input {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #f8fafc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 2px rgba(129, 140, 248, 0.25), 
                        0 0 15px rgba(129, 140, 248, 0.1);
            background: rgba(15, 23, 42, 0.8);
            outline: none;
        }

        .custom-input::placeholder {
            color: #64748b;
        }

        /* Custom Text Gradient */
        .brand-gradient-text {
            background: linear-gradient(135deg, #a5b4fc 0%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="px-4 py-8 sm:px-6 lg:px-8">

    <!-- Ambient Lighting Background Blobs -->
    <div class="glow-blob glow-blob-1"></div>
    <div class="glow-blob glow-blob-2"></div>

    <div class="w-full max-w-[420px] glass-login-card rounded-3xl overflow-hidden transition-all duration-500">
        <!-- Logo Header -->
        <div class="p-8 pb-6 text-center border-b border-slate-800/60 relative">
            <!-- Decorative Accent line -->
            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            
            <div class="admin-logo-box login-size mx-auto mb-4 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                <i class="fas fa-store text-3xl"></i>
            </div>
            
            <h1 class="text-2xl sm:text-3xl font-extrabold font-outfit brand-gradient-text tracking-tight mb-2">
                {{ config('app.name', 'Eulozia Admin') }}
            </h1>
            <p class="text-slate-400 text-sm font-medium">Sign in to your admin dashboard</p>
        </div>

        <!-- Login Form Content -->
        <div class="p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-950/40 border border-red-500/30 rounded-2xl animate-pulse">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-400 mt-1 mr-3 flex-shrink-0"></i>
                        <span class="text-red-200 text-sm font-medium">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" id="admin-login-form">
                @csrf
                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">
                        <i class="fas fa-envelope mr-2 text-indigo-400"></i>Email Address
                    </label>
                    <input type="email" id="email" name="email" required
                        class="custom-input w-full px-4 py-3.5 rounded-xl text-sm"
                        placeholder="admin@example.com" autocomplete="email" autofocus value="{{ old('email') }}">
                </div>

                <!-- Password Input -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-400"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="custom-input w-full px-4 py-3.5 pr-12 rounded-xl text-sm"
                            placeholder="••••••••" autocomplete="current-password">
                        <button type="button" id="toggle-password" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-200 focus:outline-none transition-colors duration-200">
                            <i class="fas fa-eye text-base" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="login-submit" 
                    class="btn-primary w-full py-3.5 rounded-xl text-base font-semibold tracking-wide transition-all duration-300 flex items-center justify-center gap-2 mt-8 shadow-xl shadow-indigo-600/25">
                    <span>Sign In</span>
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-5 bg-slate-950/40 border-t border-slate-800/60 text-center">
            <p class="text-xs text-slate-500 font-medium">
                &copy; {{ date('Y') }} {{ config('app.name', 'Eulozia') }} Admin Panel. All rights reserved.
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
                showConfirmButton: false,
                background: '#0f172a',
                color: '#f8fafc',
                confirmButtonColor: '#6366f1'
            });
        </script>
    @endif

    <!-- Password visibility toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('toggle-password');
            const eyeIcon = document.getElementById('eye-icon');

            if (togglePasswordBtn && passwordInput && eyeIcon) {
                togglePasswordBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    // Toggle classes for the eye icon
                    if (isPassword) {
                        eyeIcon.classList.remove('fa-eye');
                        eyeIcon.classList.add('fa-eye-slash');
                    } else {
                        eyeIcon.classList.remove('fa-eye-slash');
                        eyeIcon.classList.add('fa-eye');
                    }
                });
            }
        });
    </script>
</body>

</html>
