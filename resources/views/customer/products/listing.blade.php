@extends('customer.layouts.master')

@section('title', $title ?? 'Products - EULOZIA Collection')

@section('content')
    @php
        $categoryName = $category ?? 'All';
    @endphp

    <main class="py-8">
        <!-- Breadcrumb -->
        <section class="bg-primary mb-8 border-b border-gray-800">
            <div class="container mx-auto px-6 py-4">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('customer.home') }}"
                                class="text-secondary transition-colors duration-300 flex items-center hover:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="ml-2 text-accent font-medium">{{ $categoryName }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <div class="container mx-auto px-4">
            <!-- Mobile Filter Button -->
            <div class="lg:hidden flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-secondary">{{ $categoryName }}</h1>
                <button id="mobileFilterToggle"
                    class="bg-accent text-primary px-4 py-2 rounded-lg hover:bg-opacity-90 transition-all duration-300 font-semibold flex items-center shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                </button>
            </div>

            <form action="{{ url()->current() }}" method="GET" id="filterForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <input type="hidden" name="sort_by" id="sortByInput" value="{{ $sortBy ?? 'newest' }}">

                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Desktop Filters Sidebar - 25% -->
                    <div id="filterSidebar" class="hidden lg:block lg:w-1/4">
                        <div class="bg-primary rounded-xl p-6 sticky top-4 border border-gray-800 shadow-xl">
                            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-800">
                                <h2 class="text-xl font-bold text-secondary">Filters</h2>
                                <a href="{{ route('customer.products.index') }}" 
                                    class="text-accent text-sm hover:underline transition-all duration-300">Clear All</a>
                            </div>

                            <div class="space-y-6">
                                <!-- Categories Filter -->
                                <div class="filter-section">
                                    <h3 class="text-secondary font-semibold mb-4 flex justify-between items-center cursor-pointer filter-toggle">
                                        Categories
                                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h3>
                                    <div class="filter-content">
                                        <div class="space-y-3 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                            @foreach($filters['categories'] as $cat)
                                                <label class="flex items-center group cursor-pointer">
                                                    <input type="checkbox" name="category_id[]" value="{{ $cat['id'] }}" 
                                                        {{ isset($categoryId) && in_array($cat['id'], (array) $categoryId) ? 'checked' : '' }}
                                                        class="filter-checkbox w-4 h-4 rounded border-gray-700 bg-gray-900 text-accent focus:ring-accent focus:ring-offset-gray-900 transition-all">
                                                    <span class="ml-3 text-gray-400 group-hover:text-accent text-sm transition-colors">{{ $cat['name'] }}</span>
                                                    <span class="ml-auto text-xs text-gray-600 bg-gray-800 px-2 py-0.5 rounded-full">{{ $cat['count'] }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Range -->
                                <div class="filter-section">
                                    <h3 class="text-secondary font-semibold mb-4 flex justify-between items-center cursor-pointer filter-toggle">
                                        Price Range
                                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </h3>
                                    <div class="filter-content">
                                        <div class="space-y-4">
                                            @php
                                                $min = $filters['price_range']['min'] ?? 0;
                                                $max = $filters['price_range']['max'] ?? 10000;
                                                $currentMin = $minPrice ?? $min;
                                                $currentMax = $maxPrice ?? $max;
                                            @endphp
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1">
                                                    <label class="text-[10px] uppercase text-gray-500 mb-1 block">Min Price</label>
                                                    <div class="relative">
                                                        <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">₹</span>
                                                        <input type="number" name="min_price" value="{{ $currentMin }}" min="{{ $min }}" max="{{ $max }}"
                                                            class="w-full bg-gray-900 border border-gray-800 text-secondary text-sm rounded-lg pl-5 pr-2 py-2 focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition-all">
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="text-[10px] uppercase text-gray-500 mb-1 block">Max Price</label>
                                                    <div class="relative">
                                                        <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">₹</span>
                                                        <input type="number" name="max_price" value="{{ $currentMax }}" min="{{ $min }}" max="{{ $max }}"
                                                            class="w-full bg-gray-900 border border-gray-800 text-secondary text-sm rounded-lg pl-5 pr-2 py-2 focus:ring-2 focus:ring-accent focus:border-transparent outline-none transition-all">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="w-full bg-accent text-primary text-xs py-2.5 rounded-lg hover:bg-opacity-90 transition-all font-bold uppercase tracking-wider shadow-lg">
                                                Apply Price
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Brands Filter -->
                                @if(!empty($filters['brands']))
                                    <div class="filter-section">
                                        <h3 class="text-secondary font-semibold mb-4 flex justify-between items-center cursor-pointer filter-toggle">
                                            Brands
                                            <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </h3>
                                        <div class="filter-content">
                                            <div class="space-y-3 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                                                @foreach($filters['brands'] as $brand)
                                                    <label class="flex items-center group cursor-pointer">
                                                        <input type="checkbox" name="brand_id[]" value="{{ $brand['id'] }}" 
                                                            {{ isset($brandId) && (is_array($brandId) ? in_array($brand['id'], $brandId) : $brandId == $brand['id']) ? 'checked' : '' }}
                                                            class="filter-checkbox w-4 h-4 rounded border-gray-700 bg-gray-900 text-accent focus:ring-accent transition-all">
                                                        <span class="ml-3 text-gray-400 group-hover:text-accent text-sm transition-colors">{{ $brand['name'] }}</span>
                                                        <span class="ml-auto text-xs text-gray-600 bg-gray-800 px-2 py-0.5 rounded-full">{{ $brand['count'] }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Attributes Filter (Dynamic) -->
                                @if(!empty($filters['attributes']))
                                    @foreach($filters['attributes'] as $attribute)
                                        <div class="filter-section">
                                            <h3 class="text-secondary font-semibold mb-4 flex justify-between items-center cursor-pointer filter-toggle">
                                                {{ $attribute['name'] }}
                                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </h3>
                                            <div class="filter-content">
                                                @if($attribute['type'] === 'color')
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($attribute['values'] as $value)
                                                            <label class="relative cursor-pointer group" title="{{ $value['label'] }}">
                                                                <input type="checkbox" name="attribute_value[]" value="{{ $value['id'] }}" 
                                                                    class="filter-checkbox hidden" {{ request()->filled('attribute_value') && in_array($value['id'], (array)request('attribute_value')) ? 'checked' : '' }}>
                                                                <span class="block w-8 h-8 rounded-full border-2 border-transparent group-hover:scale-110 transition-all" 
                                                                    style="background-color: {{ $value['color_code'] ?? '#ccc' }};"></span>
                                                                <svg class="absolute inset-0 m-auto w-4 h-4 text-white opacity-0 transition-opacity checked-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="space-y-3">
                                                        @foreach($attribute['values'] as $value)
                                                            <label class="flex items-center group cursor-pointer">
                                                                <input type="checkbox" name="attribute_value[]" value="{{ $value['id'] }}"
                                                                    {{ request()->filled('attribute_value') && in_array($value['id'], (array)request('attribute_value')) ? 'checked' : '' }}
                                                                    class="filter-checkbox w-4 h-4 rounded border-gray-700 bg-gray-900 text-accent focus:ring-accent transition-all">
                                                                <span class="ml-3 text-gray-400 group-hover:text-accent text-sm transition-colors">{{ $value['label'] ?? $value['value'] }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid - 75% -->
                    <div class="w-full lg:w-3/4">
                        <!-- Desktop Header -->
                        <div class="bg-primary rounded-xl p-6 mb-8 border border-gray-800 shadow-xl">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div>
                                    <h1 class="text-3xl font-bold text-secondary mb-2 tracking-tight">{{ $categoryName }}</h1>
                                    <p class="text-gray-500 text-sm">
                                        Showing <span class="text-accent font-semibold">{{ count($products) }}</span> of
                                        <span class="text-accent font-semibold">{{ $paginator['total'] ?? 0 }}</span> curated products
                                    </p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <label class="text-sm text-gray-500 whitespace-nowrap hidden sm:block">Sort by:</label>
                                    <select id="sortByDropdown"
                                        class="bg-gray-900 text-secondary text-sm border border-gray-800 px-4 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-all cursor-pointer">
                                        <option value="newest" {{ ($sortBy ?? '') == 'newest' ? 'selected' : '' }}>Newest Arrival</option>
                                        <option value="featured" {{ ($sortBy ?? '') == 'featured' ? 'selected' : '' }}>Featured</option>
                                        <option value="price_low" {{ ($sortBy ?? '') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_high" {{ ($sortBy ?? '') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="popular" {{ ($sortBy ?? '') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        @if(count($products) > 0)
                            <div id="productsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($products as $product)
                                    @include('customer.partials.product-card', ['product' => $product])
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if(!empty($paginator) && $paginator['last_page'] > 1)
                                <div class="mt-16 flex justify-center">
                                    <nav class="flex items-center gap-2">
                                        @if($paginator['current_page'] > 1)
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $paginator['current_page'] - 1]) }}"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary border border-gray-800 text-gray-400 hover:bg-accent hover:text-primary transition-all duration-300">
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif

                                        @for($i = max(1, $paginator['current_page'] - 2); $i <= min($paginator['last_page'], $paginator['current_page'] + 2); $i++)
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg border transition-all duration-300 {{ $i == $paginator['current_page'] ? 'bg-accent border-accent text-primary font-bold' : 'bg-primary border-gray-800 text-gray-400 hover:border-accent hover:text-accent' }}">
                                                {{ $i }}
                                            </a>
                                        @endfor

                                        @if($paginator['current_page'] < $paginator['last_page'])
                                            <a href="{{ request()->fullUrlWithQuery(['page' => $paginator['current_page'] + 1]) }}"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary border border-gray-800 text-gray-400 hover:bg-accent hover:text-primary transition-all duration-300">
                                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        @endif
                                    </nav>
                                </div>
                            @endif
                        @else
                            <div class="bg-primary rounded-xl p-12 text-center border border-gray-800 shadow-xl">
                                <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-secondary mb-2">No Products Found</h3>
                                <p class="text-gray-500 mb-8">We couldn't find any products matching your current filters. Try adjusting them to see more items.</p>
                                <a href="{{ route('customer.products.index') }}" class="inline-flex items-center px-6 py-3 bg-accent text-primary font-bold rounded-lg hover:bg-opacity-90 transition-all">
                                    Reset All Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('styles')
<style>
    .filter-checkbox:checked + span {
        color: #fff; /* or your accent color */
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #374151;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #4b5563;
    }
    input[type=checkbox]:checked ~ .checked-icon {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.getElementById('filterForm');
            const sortByDropdown = document.getElementById('sortByDropdown');
            const sortByInput = document.getElementById('sortByInput');
            const checkboxes = document.querySelectorAll('.filter-checkbox');
            const mobileFilterToggle = document.getElementById('mobileFilterToggle');
            const filterSidebar = document.getElementById('filterSidebar');

            // Sorting Logic
            if (sortByDropdown) {
                sortByDropdown.addEventListener('change', function () {
                    sortByInput.value = this.value;
                    filterForm.submit();
                });
            }

            // Auto-submit on checkbox change
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    // Prevent immediate submit if wanted, but for better UX we submit
                    // Maybe show a loading spinner
                    filterForm.submit();
                });
            });

            // Mobile Toggle
            if (mobileFilterToggle) {
                mobileFilterToggle.addEventListener('click', function() {
                    filterSidebar.classList.toggle('hidden');
                    filterSidebar.scrollIntoView({ behavior: 'smooth' });
                });
            }

            // Filter Section Toggle Logic
            const toggles = document.querySelectorAll('.filter-toggle');
            toggles.forEach(toggle => {
                toggle.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('svg');
                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });

            // Visual check for initial state
            document.querySelectorAll('.filter-checkbox:checked').forEach(cb => {
                const icon = cb.parentElement.querySelector('.checked-icon');
                if (icon) icon.style.opacity = '1';
            });
        });
    </script>
@endpush
