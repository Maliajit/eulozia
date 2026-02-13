@extends('customer.layouts.master')

@section('title', 'Forgot Password - Eulozia')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-primary">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-10 text-center border-b border-gray-800">
                <div class="w-20 h-20 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-accent">
                    <i class="fas fa-key text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-secondary mb-3">Forgot Password?</h1>
                <p class="text-accent leading-relaxed">No worries, we'll send you instructions to reset your password.</p>
            </div>

            <div class="p-10">
                <!-- Alert Messages -->
                @if(session('status'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl mb-8 text-sm text-center">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('customer.forgot-password') }}" class="space-y-8">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-secondary mb-3">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                   class="w-full bg-gray-800 border-gray-700 text-secondary pl-12 pr-4 py-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('email') border-red-500 @enderror"
                                   placeholder="Enter your registered email" required focus autocomplete="email">
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-accent text-primary py-4 px-6 rounded-xl font-bold hover:bg-white hover:scale-[1.02] active:scale-95 transition-all duration-300 shadow-lg uppercase tracking-wider">
                        Send reset link
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="mt-10 text-center">
                    <a href="{{ route('customer.login') }}" class="inline-flex items-center text-accent hover:text-secondary font-bold transition-all duration-300 group">
                        <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform"></i>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
