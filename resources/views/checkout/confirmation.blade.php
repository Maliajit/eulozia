@extends('layouts.master')

@section('title', 'Order Confirmed - Fashion Store')

@section('content')
<main class="py-12">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">Thank You!</h1>
        <p class="text-xl text-accent mb-8">Your order has been placed successfully.</p>
        <a href="{{ route('home') }}" class="bg-white text-black px-8 py-3 font-bold hover:bg-accent transition-colors">CONTINUE SHOPPING</a>
    </div>
</main>
@endsection
