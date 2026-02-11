@extends('layouts.master')

@section('title', 'Wishlist - Fashion Store')

@section('content')
<main class="py-12">
    <div class="container mx-auto px-6">
        <h1 class="text-3xl font-bold mb-8">My Wishlist</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <p class="text-accent col-span-full text-center py-12">Your wishlist is empty.</p>
        </div>
    </div>
</main>
@endsection
