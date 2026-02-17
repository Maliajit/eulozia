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
                                <label for="mobile" class="block text-sm font-medium text-secondary mb-2">Mobile
                                    Number</label>
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
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-secondary mb-2">Confirm Password</label>
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
                                I agree to the <a href="#" class="text-secondary hover:underline">Terms of Service</a> and
                                <a href="#" class="text-secondary hover:underline">Privacy Policy</a>
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
                            <a href="{{ route('customer.login') }}"
                                class="text-secondary font-bold hover:text-accent transition-colors ml-1">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection