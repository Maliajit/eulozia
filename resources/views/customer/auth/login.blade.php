@extends('customer.layouts.master')

@section('title', 'Login - Eulozia')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-primary">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-8 text-center border-b border-gray-800">
                <h1 class="text-3xl font-bold text-secondary mb-2">Welcome Back</h1>
                <p class="text-accent">Login to access your account</p>
            </div>

            <div class="p-8">
                <!-- Social Login Buttons -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <button class="flex items-center justify-center gap-2 bg-gray-800 text-secondary py-3 px-4 rounded-xl hover:bg-gray-700 transition-all duration-300 border border-gray-700 active:scale-95">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="font-medium">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 bg-gray-800 text-secondary py-3 px-4 rounded-xl hover:bg-gray-700 transition-all duration-300 border border-gray-700 active:scale-95">
                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="font-medium">Facebook</span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative mb-8 text-center">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-800"></div>
                    </div>
                    <span class="relative px-4 bg-gray-900 text-sm text-accent">Or login with email</span>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl mb-6 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 px-4 py-3 rounded-xl mb-6 text-sm">
                        {{ session('warning') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('customer.login.submit') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                   class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror"
                                   placeholder="name@example.com" required autocomplete="email">
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-secondary">Password</label>
                            <a href="{{ route('customer.forgot-password') }}" class="text-xs text-accent hover:text-secondary transition-colors">Forgot Password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" 
                                   class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror"
                                   placeholder="••••••••" required autocomplete="current-password">
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent transition-colors">
                        <label for="remember" class="ml-2 text-sm text-accent">Remember me for 30 days</label>
                    </div>

                    <button type="submit" 
                            class="w-full bg-accent text-primary py-4 px-6 rounded-xl font-bold hover:bg-white hover:scale-[1.02] active:scale-95 transition-all duration-300 shadow-lg mt-2">
                        LOGIN
                    </button>
                </form>

                <!-- Signup Link -->
                <div class="mt-8 text-center bg-gray-800/50 p-4 rounded-xl border border-gray-800">
                    <p class="text-accent text-sm">
                        Don't have an account? 
                        <a href="{{ route('customer.register') }}" class="text-secondary font-bold hover:text-accent transition-colors ml-1">Create Account</a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer Info -->
        <p class="mt-8 text-center text-gray-600 text-xs">
            © 2026 Eulozia. All rights reserved. <br>
            Secure, encrypted login powered by Eulozia Auth.
        </p>
    </div>
</div>
@endsection
