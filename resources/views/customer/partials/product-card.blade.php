<div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
    <div class="relative overflow-hidden flex-shrink-0">
        <div class="product-carousel relative h-80 bg-gray-700" data-current-slide="0">
            <!-- Product Images -->
            <a href="{{ route('customer.products.show', ['slug' => $product['slug']]) }}">
                <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                    @if(!empty($product['images']))
                        @foreach ($product['images'] as $image)
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="{{ Str::startsWith($image['url'], 'http') ? $image['url'] : asset('storage/' . $image['url']) }}" alt="{{ $product['name'] }}"
                                    class="w-full h-full object-cover" />
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-image flex-shrink-0 w-full h-full">
                            <img src="{{ asset('images/placeholder-product.jpg') }}" alt="{{ $product['name'] }}"
                                class="w-full h-full object-cover" />
                        </div>
                    @endif
                </div>
            </a>

            <!-- Navigation Buttons - Hidden on mobile -->
            @if (!empty($product['images']) && count($product['images']) > 1)
                <button type="button"
                    class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <button type="button"
                    class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @endif

            @if (isset($product['is_in_stock']) && !$product['is_in_stock'])
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20">
                    <span class="bg-gray-800 text-accent px-3 py-1 rounded text-sm font-bold">OUT OF STOCK</span>
                </div>
            @endif
        </div>
    </div>

    <div class="p-4 flex-1 flex flex-col">
        <h3 class="product-title font-semibold mb-1 text-sm md:text-base">
            <a href="{{ route('customer.products.show', ['slug' => $product['slug']]) }}" class="hover:text-accent transition-colors duration-300">
                {{ $product['name'] }}
            </a>
        </h3>
        <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">
            {{ $product['brand'] ?? 'EULOZIA' }}
        </p>
        <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
            @if ($product['compare_price'] && $product['compare_price'] > $product['price'])
                <span class="original-price text-secondary text-xs line-through">₹{{ number_format($product['compare_price']) }}</span>
                <span class="discounted-price text-secondary text-sm font-bold">₹{{ number_format($product['price']) }}</span>
                <span class="discount-percent text-green-500 text-xs font-medium">
                    {{ $product['discount_percent'] }}% OFF
                </span>
            @else
                <span class="discounted-price text-secondary text-sm font-bold">₹{{ number_format($product['price']) }}</span>
            @endif
        </div>
    </div>
</div>
