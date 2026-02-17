<div
    class="product-card bg-primary overflow-hidden group flex flex-col h-full shadow-sm transition-all duration-300 hover:shadow-md">
    <div class="relative overflow-hidden flex-shrink-0">
        <div class="product-inline-carousel relative h-80 bg-gray-100 overflow-hidden">
            <!-- Product Images -->
            <a href="{{ route('customer.products.show', $product['slug']) }}">
                <div class="carousel-track flex transition-transform duration-500 ease-in-out h-full" data-current="0">
                    @forelse($product['images'] as $image)
                        <div class="carousel-slide flex-shrink-0 w-full h-full">
                            <img src="{{ $image['url'] }}" alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover" />
                        </div>
                    @empty
                        <div class="carousel-slide flex-shrink-0 w-full h-full">
                            <img src="{{ $product['main_image'] }}" alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover" />
                        </div>
                    @endforelse
                </div>
            </a>

            <!-- Navigation Buttons - Hidden on mobile -->
            @if(count($product['images'] ?? []) > 1)
                <button type="button" onclick="slide(this, -1)"
                    class="carousel-nav-btn absolute left-2 top-1/2 transform -translate-y-1/2 bg-black/40 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:flex items-center justify-center w-8 h-8 z-10 hover:bg-black/60">
                    <i class="fas fa-chevron-left text-xs"></i>
                </button>
                <button type="button" onclick="slide(this, 1)"
                    class="carousel-nav-btn absolute right-2 top-1/2 transform -translate-y-1/2 bg-black/40 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:flex items-center justify-center w-8 h-8 z-10 hover:bg-black/60">
                    <i class="fas fa-chevron-right text-xs"></i>
                </button>
            @endif
        </div>
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <h3 class="product-title font-semibold text-secondary mb-1 text-sm md:text-base line-clamp-2">
            {{ $product['name'] }}
        </h3>
        <p class="product-variant text-gray-500 text-xs mb-3 flex-shrink-0 uppercase tracking-wider">
            {{ $product['category'] ?? 'New Arrival' }}
        </p>
        <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
            @if($product['compare_price'] && $product['compare_price'] > $product['price'])
                <span
                    class="original-price text-gray-400 text-xs line-through">₹{{ number_format($product['compare_price']) }}</span>
            @endif
            <span
                class="discounted-price text-secondary text-sm font-bold">₹{{ number_format($product['price']) }}</span>
            @if($product['discount_percent'] > 0)
                <span class="discount-percent text-green-500 text-xs font-semibold">{{ $product['discount_percent'] }}%
                    OFF</span>
            @endif
        </div>
    </div>
</div>