@extends('customer.layouts.master')

@section('title', 'Order Success - Fashion Store')

@section('content')
<main class="py-20">
    <div class="container mx-auto px-6 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-600 rounded-full mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h1 class="text-4xl font-bold mb-4 text-secondary">Order Placed Successfully!</h1>
        <p class="text-gray-400 mb-8 max-w-md mx-auto">
            Thank you for your purchase. Your order has been received and is being processed. 
            A confirmation email has been sent to your registered email address.
        </p>
        <div class="bg-primary p-6 rounded-lg inline-block border border-gray-800 shadow-xl mb-8">
            <p class="text-secondary font-semibold">Order ID: <span class="text-accent">{{ request()->query('order_id', 'N/A') }}</span></p>
        </div>
        <div>
            <a href="{{ route('customer.home') }}" class="bg-accent text-primary px-8 py-3 rounded-lg font-bold hover:bg-opacity-90 transition-all inline-block uppercase tracking-wider">
                Continue Shopping
            </a>
        </div>
    </div>
</main>
@endsection
