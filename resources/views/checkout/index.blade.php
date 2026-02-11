@extends('layouts.master')

@section('title', 'Checkout - Fashion Store')

@section('content')
@push('head')
<!-- Razorpay SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush

<main class="py-0">
    <!-- Breadcrumb Section -->
    <section class="bg-primary">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-secondary transition-colors duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="ml-2 text-secondary">Checkout</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold mb-8 text-center">Secure Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Forms -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Information, Shipping Address, Shipping Method, Payment Method sections as per checkout.php -->
                <div class="bg-primary p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary">Contact Information</h2>
                    <form id="checkoutForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="firstName" placeholder="First Name *" required class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-secondary">
                            <input type="text" name="lastName" placeholder="Last Name *" required class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg text-secondary">
                        </div>
                    </form>
                </div>
                
                <!-- More sections follow -->
            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-primary p-6 rounded-lg shadow-lg sticky top-6">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary">Order Summary</h2>
                    <!-- Summary items labels, price breakdown, promo code, place order button -->
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
