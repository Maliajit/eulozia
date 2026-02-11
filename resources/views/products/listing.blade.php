@extends('layouts.master')

@section('title', 'Products - Fashion Store')

@section('content')
@php
    // In a real Laravel app, $products, $brands, $sizes, etc. would be passed from the controller.
    // For this migration, we'll keep the sample data structure for consistency.
    $categoryName = ucfirst($category ?? 'All');
@endphp

<main class="py-8">
    <!-- Breadcrumb -->
    <section class="bg-primary mb-8">
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
                        <span class="ml-2 text-secondary">{{ $categoryName }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container mx-auto px-4">
        <!-- Mobile Filter Button -->
        <div class="lg:hidden flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-secondary">{{ $categoryName }} Collection</h1>
            <button id="mobileFilterToggle" class="bg-accent text-primary px-4 py-2 rounded hover:bg-gray-300 transition-colors duration-300 font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filters
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Desktop Filters Sidebar - 25% -->
            <div class="hidden lg:block lg:w-1/4">
                <div class="bg-primary rounded-lg p-6 sticky top-4">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-secondary">Filters</h2>
                        <button id="clearAllFilters" class="text-accent text-sm hover:text-secondary transition-colors duration-300">Clear All</button>
                    </div>

                    <div class="space-y-6">
                        <!-- Gender Filter -->
                        <div class="filter-section">
                            <h3 class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Gender
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    @foreach(['Men', 'Women', 'Unisex', 'Kids'] as $gender)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="gender" value="{{ strtolower($gender) }}" class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">{{ $gender }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="filter-section">
                            <h3 class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Price Range
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="mb-4">
                                    <input type="range" id="priceRange" min="0" max="10000" step="100" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                    <div class="flex justify-between text-accent text-sm mt-2">
                                        <span>₹0</span>
                                        <span>₹10,000</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Brands, Sizes, Colors would go here following the same pattern -->
                    </div>
                </div>
            </div>

            <!-- Products Grid - 75% -->
            <div class="w-full lg:w-3/4">
                <!-- Desktop Header -->
                <div class="bg-primary rounded-lg p-6 mb-6 hidden lg:block">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-secondary mb-2">{{ $categoryName }} Collection</h1>
                            <p class="text-accent">Showing <span id="productCount">8</span> products</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-4 lg:mt-0">
                            <select id="sortBy" class="bg-gray-800 text-secondary px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-accent">
                                <option value="featured">Featured</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="productsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        // Mock products for the migration demo
                        $mockProducts = [
                            ['id' => 1, 'name' => 'Oversized Cotton T-Shirt', 'price' => 1999, 'discounted_price' => 1499, 'brand' => 'Urban Classic', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'rating' => 4.5, 'in_stock' => true],
                            ['id' => 2, 'name' => 'Slim Fit Denim Jeans', 'price' => 3999, 'discounted_price' => 2999, 'brand' => 'Denim Co', 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'rating' => 4.2, 'in_stock' => true],
                            ['id' => 3, 'name' => 'Floral Print Summer Dress', 'price' => 2999, 'discounted_price' => 1999, 'brand' => 'Summer Bliss', 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'rating' => 4.7, 'in_stock' => true],
                            ['id' => 4, 'name' => 'Formal Linen Shirt', 'price' => 2499, 'discounted_price' => 1999, 'brand' => 'Executive Wear', 'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80', 'rating' => 4.3, 'in_stock' => false],
                        ];
                    @endphp

                    @foreach($mockProducts as $product)
                    <div class="product-card bg-primary rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="relative">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-64 object-cover">
                            @if($product['discounted_price'] < $product['price'])
                                <div class="absolute top-2 left-2 bg-red-600 text-secondary px-2 py-1 rounded text-sm font-semibold">
                                    {{ round((($product['price'] - $product['discounted_price']) / $product['price']) * 100) }}% OFF
                                </div>
                            @endif
                            @if(!$product['in_stock'])
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="bg-gray-800 text-accent px-3 py-1 rounded text-sm">Out of Stock</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-secondary font-semibold mb-2 truncate">{{ $product['name'] }}</h3>
                            <p class="text-accent text-sm mb-2">{{ $product['brand'] }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-secondary font-bold text-lg">₹{{ number_format($product['discounted_price']) }}</span>
                                    @if($product['discounted_price'] < $product['price'])
                                        <span class="text-accent text-sm line-through">₹{{ number_format($product['price']) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', ['id' => $product['id']]) }}" class="bg-accent text-primary px-4 py-2 rounded hover:bg-gray-300 transition-colors duration-300">View Detail</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.filter-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('svg');
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>
@endpush
