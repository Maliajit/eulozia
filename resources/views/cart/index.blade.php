@extends('layouts.master')

@section('title', 'Cart - Fashion Store')

@section('content')
<main class="py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>
        <!-- Cart Items and Summary -->
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3">
                <p class="text-accent">Your cart is currently empty.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-white text-black px-6 py-2 font-bold hover:bg-accent transition-colors">START SHOPPING</a>
            </div>
        </div>
    </div>
</main>
@endsection
