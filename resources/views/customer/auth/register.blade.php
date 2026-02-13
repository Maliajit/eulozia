@extends('customer.layouts.master')

@section('title', 'Create Account - Eulozia')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-primary lg:py-12">
    <div class="max-w-xl w-full">
        <!-- Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-8 text-center border-b border-gray-800">
                <h1 class="text-3xl font-bold text-secondary mb-2">Join Eulozia</h1>
                <p class="text-accent">Create an account to track orders and save favorites</p>
            </div>

            <div class="p-8">
                <!-- Social Auth Buttons -->
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
                    <span class="relative px-4 bg-gray-900 text-sm text-accent">Or register with email</span>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('customer.register.submit') }}" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-secondary mb-2">Full Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                                       class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('name') border-red-500 @enderror"
                                       placeholder="John Doe" required>
                            </div>
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mobile" class="block text-sm font-medium text-secondary mb-2">Mobile Number</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="tel" id="mobile" name="mobile" value="{{ old('mobile') }}" 
                                       class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('mobile') border-red-500 @enderror"
                                       placeholder="9876543210" required>
                            </div>
                            @error('mobile')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                   class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror"
                                   placeholder="name@example.com" required>
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-secondary mb-2">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" id="password" name="password" 
                                       class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('password') border-red-500 @enderror"
                                       placeholder="••••••••" required>
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-secondary mb-2">Confirm Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="w-full bg-gray-800 border-gray-700 text-secondary pl-10 pr-4 py-3.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300"
                                       placeholder="••••••••" required>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="terms" name="terms" required 
                                   class="w-4 h-4 rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent transition-colors @error('terms') border-red-500 @enderror">
                        </div>
                        <label for="terms" class="ml-3 text-sm text-accent leading-tight">
                            I agree to the <a href="#" class="text-secondary hover:underline">Terms of Service</a> and <a href="#" class="text-secondary hover:underline">Privacy Policy</a>
                        </label>
                    </div>
                    @error('terms')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <button type="submit" 
                            class="w-full bg-accent text-primary py-4 px-6 rounded-xl font-bold hover:bg-white hover:scale-[1.01] active:scale-95 transition-all duration-300 shadow-lg">
                        CREATE ACCOUNT
                    </button>
                </form>

                <!-- Footer Link -->
                <div class="mt-8 text-center bg-gray-800/50 p-4 rounded-xl border border-gray-800">
                    <p class="text-accent text-sm">
                        Already have an account? 
                        <a href="{{ route('customer.login') }}" class="text-secondary font-bold hover:text-accent transition-colors ml-1">Login here</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
