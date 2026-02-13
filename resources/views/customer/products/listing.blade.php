@extends('customer.layouts.master')

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
                            <a href="{{ route('customer.home') }}"
                                class="text-secondary transition-colors duration-300 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
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
                <button id="mobileFilterToggle"
                    class="bg-accent text-primary px-4 py-2 rounded hover:bg-gray-300 transition-colors duration-300 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
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
                            <a href="{{ route('customer.products.index') }}" id="clearAllFilters"
                                class="text-accent text-sm hover:text-secondary transition-colors duration-300">Clear
                                All</a>
                        </div>

                        <form action="{{ route('customer.products.index') }}" method="GET" id="filterForm">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <div class="space-y-6">
                                <!-- Categories Filter -->
                                <div class="filter-section">
                                    <h3
                                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                        Categories
                                        <svg class="w-4 h-4 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h3>
                                    <div class="filter-content">
                                        <div class="space-y-2">
                                            @foreach($filters['categories'] as $cat)
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="category_id[]" value="{{ $cat['id'] }}" {{ isset($categoryId) && in_array($cat['id'], (array) $categoryId) ? 'checked' : '' }}
                                                        class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                                    <span class="ml-2 text-accent text-sm">{{ $cat['name'] }}
                                                        ({{ $cat['count'] }})</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="filter-section">
                                    <h3
                                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                        Price Range
                                        <svg class="w-4 h-4 transform transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h3>
                                    <div class="filter-content">
                                        <div class="mb-4">
                                            @php
                                                $min = $filters['price_range']['min'] ?? 0;
                                                $max = $filters['price_range']['max'] ?? 10000;
                                                $currentMin = $minPrice ?? $min;
                                                $currentMax = $maxPrice ?? $max;
                                            @endphp
                                            <div class="flex items-center space-x-2 mb-2">
                                                <input type="number" name="min_price" value="{{ $currentMin }}"
                                                    placeholder="Min"
                                                    class="w-1/2 bg-gray-800 border-gray-700 text-secondary text-xs rounded px-2 py-1 focus:ring-accent">
                                                <span class="text-accent text-xs">-</span>
                                                <input type="number" name="max_price" value="{{ $currentMax }}"
                                                    placeholder="Max"
                                                    class="w-1/2 bg-gray-800 border-gray-700 text-secondary text-xs rounded px-2 py-1 focus:ring-accent">
                                            </div>
                                            <button type="submit"
                                                class="w-full bg-accent text-primary text-xs py-1 rounded hover:bg-gray-300 transition-colors font-bold uppercase">Apply
                                                Filters</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Brands Filter -->
                                @if(!empty($filters['brands']))
                                    <div class="filter-section">
                                        <h3
                                            class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                            Brands
                                            <svg class="w-4 h-4 transform transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </h3>
                                        <div class="filter-content">
                                            <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                                                @foreach($filters['brands'] as $brand)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="brand_id[]" value="{{ $brand['id'] }}" {{ isset($brandId) && (is_array($brandId) ? in_array($brand['id'], $brandId) : $brandId == $brand['id']) ? 'checked' : '' }}
                                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                                        <span class="ml-2 text-accent text-sm">{{ $brand['name'] }}
                                                            ({{ $brand['count'] }})</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <button type="submit"
                                                class="w-full bg-accent text-primary text-xs py-1 mt-4 rounded hover:bg-gray-300 transition-colors font-bold uppercase">Apply
                                                Filters</button>
                                        </div>
                                    </div>
                                @endif

                        </form>

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
                            <p class="text-accent">Showing <span id="productCount">{{ count($products) }}</span> of
                                {{ $paginator['total'] ?? 0 }} products</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-4 lg:mt-0">
                            <select id="sortBy"
                                class="bg-gray-800 text-secondary px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-accent">
                                <option value="featured">Featured</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="productsContainer" class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        // Mock products removed - using real $products from controller
                    @endphp

                    @foreach ($products as $product)
                        @include('customer.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(!empty($paginator) && $paginator['last_page'] > 1)
                    <div class="mt-12 flex justify-center">
                        <nav class="flex items-center space-x-2">
                            @if($paginator['current_page'] > 1)
                                <a href="?page={{ $paginator['current_page'] - 1 }}{{ request()->filled('search') ? '&search=' . request('search') : '' }}{{ request()->filled('category_id') ? '&category_id=' . request('category_id') : '' }}"
                                    class="p-2 rounded-lg bg-primary text-secondary hover:bg-accent hover:text-primary transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            @for($i = max(1, $paginator['current_page'] - 2); $i <= min($paginator['last_page'], $paginator['current_page'] + 2); $i++)
                                <a href="?page={{ $i }}{{ request()->filled('search') ? '&search=' . request('search') : '' }}{{ request()->filled('category_id') ? '&category_id=' . request('category_id') : '' }}"
                                    class="px-4 py-2 rounded-lg transition-colors duration-300 {{ $i == $paginator['current_page'] ? 'bg-accent text-primary font-bold' : 'bg-primary text-secondary hover:bg-gray-800' }}">
                                    {{ $i }}
                                </a>
                            @endfor

                            @if($paginator['current_page'] < $paginator['last_page'])
                                <a href="?page={{ $paginator['current_page'] + 1 }}{{ request()->filled('search') ? '&search=' . request('search') : '' }}{{ request()->filled('category_id') ? '&category_id=' . request('category_id') : '' }}"
                                    class="p-2 rounded-lg bg-primary text-secondary hover:bg-accent hover:text-primary transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>
        </div>
        </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Filter Toggle Logic
            const toggles = document.querySelectorAll('.filter-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('svg');
                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });
        });
    </script>
@endpush