@extends('customer.layouts.master')

@section('title', 'Payment Failed - Fashion Store')

@section('content')
    <main class="py-20">
        <div class="container mx-auto px-6 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 text-red-600 rounded-full mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4 text-secondary">Payment Failed</h1>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">
                Unfortunately, your transaction could not be completed at this time.
                Don't worry, if any amount was deducted, it will be refunded to your account automatically within 5-7
                business days.
            </p>

            @if(session('error'))
                <div
                    class="bg-red-500 bg-opacity-10 border border-red-500 text-red-500 p-4 rounded-lg inline-block mb-8 max-w-lg">
                    <p class="font-medium text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('customer.checkout.index') }}"
                    class="bg-accent text-primary px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition-all inline-block uppercase tracking-wider">
                    Try Again
                </a>
                <a href="{{ route('customer.home') }}"
                    class="bg-transparent border border-gray-700 text-secondary px-8 py-3 rounded-lg font-bold hover:bg-gray-800 transition-all inline-block uppercase tracking-wider">
                    Back to Home
                </a>
            </div>

            <p class="mt-12 text-sm text-gray-500">
                Need help? <a href="#" class="text-accent hover:underline">Contact our support team</a>
            </p>
        </div>
    </main>
@endsection