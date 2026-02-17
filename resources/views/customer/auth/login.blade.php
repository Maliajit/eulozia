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


                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div
                            class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl mb-6 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div
                            class="bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 px-4 py-3 rounded-xl mb-6 text-sm">
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
                                <a href="{{ route('customer.forgot-password') }}"
                                    class="text-xs text-accent hover:text-secondary transition-colors">Forgot Password?</a>
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
                            <input type="checkbox" id="remember" name="remember"
                                class="w-4 h-4 rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent transition-colors">
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
                            <a href="{{ route('customer.register') }}"
                                class="text-secondary font-bold hover:text-accent transition-colors ml-1">Create Account</a>
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