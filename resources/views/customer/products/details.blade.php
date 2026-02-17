@extends('customer.layouts.master')

@section('title', 'Product Details - Fashion Store')

@section('content')
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
                            <a href="{{ route('customer.products.index') }}"
                                class="ml-2 text-secondary transition-colors duration-300">Products</a>
                        </li>
                        @if(isset($product['category']))
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{ route('customer.products.index', ['category' => $product['category']['slug']]) }}"
                                    class="ml-2 text-secondary transition-colors duration-300">{{ $product['category']['name'] }}</a>
                            </li>
                        @endif
                        <li class="flex items-center" aria-current="page">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="ml-2 text-secondary">{{ $product['name'] }}</span>
                        </li>
                    </ol>
                </nav>
            </div>
        </section>

        <div class="container mx-auto px-2">
            <div class="flex flex-col lg:flex-row">
                <!-- Image Gallery - 60% on large, 50% on tablet, full width on mobile -->
                <div class="w-full md:w-1/2 lg:w-3/5 mb-6 lg:mb-0">
                    <!-- Mobile & Tablet Carousel -->
                    <div class="block md:block lg:hidden product-carousel bg-primary p-4 rounded-lg">
                        <div class="relative overflow-hidden rounded-lg">
                            <div class="carousel-images flex transition-transform duration-300 ease-in-out">
                                @foreach ($product['images'] as $index => $image)
                                    <div class="carousel-image w-full flex-shrink-0">
                                        <img src="{{ $image['url'] }}" alt="Product image {{ $index + 1 }}"
                                            class="w-full h-96 object-cover rounded-lg cursor-pointer"
                                            onclick="openFullscreen('{{ $image['url'] }}')">
                                    </div>
                                @endforeach
                            </div>

                            <!-- Navigation Buttons -->
                            <button
                                class="carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-primary bg-opacity-70 text-secondary p-2 rounded hover:bg-opacity-100 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button
                                class="carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary bg-opacity-70 text-secondary p-2 rounded-full hover:bg-opacity-100 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>

                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                @foreach ($product['images'] as $index => $image)
                                    <button
                                        class="carousel-indicator w-3 h-3 rounded-full bg-secondary bg-opacity-50 transition-all duration-300 {{ $index === 0 ? 'active opacity-100' : '' }}"
                                        data-index="{{ $index }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Desktop Grid (Hidden on mobile/tablet) -->
                    <div class="hidden lg:block bg-primary ">
                        <!-- Thumbnail Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-2">
                            @foreach ($product['images'] as $index => $image)
                                <div class="cursor-pointer">
                                    <img src="{{ $image['url'] }}" alt="Product image {{ $index + 1 }}"
                                        class="w-full h-full object-cover" onclick="openFullscreen('{{ $image['url'] }}')">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Product Details - 40% on large, 50% on tablet, full width on mobile -->
                <div class="w-full md:w-1/2 lg:w-2/5 ">
                    <div class="bg-primary rounded-lg p-6 sticky top-4">
                        <!-- Product Name -->
                        <h1 class="text-2xl font-bold text-secondary mb-2">{{ $product['name'] }}</h1>

                        @if(isset($product['brand']) && $product['brand'])
                            <!-- Brand -->
                            <p class="text-accent text-lg mb-4">{{ $product['brand']['name'] }}</p>
                        @endif

                        <!-- Price -->
                        <div class="flex items-center space-x-3 mb-4 ">
                            <span class="text-secondary text-xl font-bold">₹{{ number_format($product['price'], 2) }}</span>
                            @if($product['compare_price'] && $product['compare_price'] > $product['price'])
                                <span
                                    class="text-accent text-sm line-through">₹{{ number_format($product['compare_price'], 2) }}</span>
                                <span class="text-green-500 text-sm font-medium bg-green-500 bg-opacity-20 px-2 py-1 rounded">
                                    {{ $product['discount_percent'] }}% OFF
                                </span>
                            @endif
                        </div>

                        <!-- Tax Info -->
                        <p class="text-accent text-sm mb-6">(Incl. of all taxes)</p>

                        <!-- Size/Variant Selection -->
                        @if(isset($product['attribute_groups']) && count($product['attribute_groups']) > 0)
                            <div class="mb-6">
                                @foreach($product['attribute_groups'] as $attributeName => $attributeGroup)
                                    <h3 class="text-secondary font-semibold mb-3">{{ $attributeName }}</h3>
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach ($attributeGroup['options'] as $option)
                                            <label class="inline-flex items-center cursor-pointer group" title="{{ $option['label'] }}">
                                                <input type="radio" name="attribute_{{ $attributeName }}" value="{{ $option['value'] }}"
                                                    class="hidden peer">
                                                @if(isset($attributeGroup['type']) && $attributeGroup['type'] === 'color')
                                                    @php
                                                        $colorCode = $option['color_code'] ?? '';
                                                        if (empty($colorCode) && isset($option['label']) && (Str::startsWith($option['label'], '#') || preg_match('/^[a-fA-F0-9]{3,6}$/', $option['label']))) {
                                                            $colorCode = $option['label'];
                                                        }
                                                        if (empty($colorCode))
                                                            $colorCode = '#ccc';
                                                        if (!Str::startsWith($colorCode, '#') && !Str::startsWith($colorCode, 'rgb') && !Str::startsWith($colorCode, 'hsl')) {
                                                            $colorCode = '#' . $colorCode;
                                                        }
                                                        $hexVal = strtoupper(str_replace('#', '', $colorCode));
                                                        $isWhite = in_array($hexVal, ['FFFFFF', 'FFF', 'F9F9F9', 'F3F4F6', 'EEEEEE', 'E5E7EB']);
                                                        $isBlack = in_array($hexVal, ['000000', '000', '111111', '1F2937']);
                                                    @endphp
                                                    <span
                                                        class="w-10 h-10 rounded-full border-2 {{ $isWhite ? 'border-gray-300' : ($isBlack ? 'border-gray-700' : 'border-transparent') }} peer-checked:border-accent group-hover:scale-110 transition-all shadow-sm flex items-center justify-center relative"
                                                        style="background-color: {{ $colorCode }};">
                                                        <svg class="w-5 h-5 {{ $isWhite ? 'text-gray-900' : 'text-white' }} opacity-0 peer-checked:opacity-100 transition-opacity"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                                d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </span>
                                                @else
                                                    <span
                                                        class="px-4 py-2 border border-accent text-accent rounded-md transition-all duration-300 peer-checked:bg-accent peer-checked:text-primary peer-checked:border-accent">
                                                        {{ $option['label'] }}
                                                    </span>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-6">
                            <h3 class="text-secondary font-semibold mb-3">Quantity</h3>
                            <div class="flex items-center space-x-3">
                                <button
                                    class="w-10 h-10 rounded-full border border-accent text-accent flex items-center justify-center hover:bg-accent hover:text-primary transition-colors duration-300 quantity-btn"
                                    data-action="decrease">-</button>
                                <span class="text-secondary text-lg font-semibold w-8 text-center quantity-display">1</span>
                                <button
                                    class="w-10 h-10 rounded-full border border-accent text-accent flex items-center justify-center hover:bg-accent hover:text-primary transition-colors duration-300 quantity-btn"
                                    data-action="increase">+</button>
                            </div>
                        </div>

                        <!-- Payment Options -->
                        <div class="mb-6 p-4 bg-gray-800 rounded-lg text-center">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-secondary text-sm">PAY NOW ₹270 REST PAY LATER</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-accent text-xs">AT 0% EMI ON <strong>LIPP!</strong></span>
                                <button
                                    class="text-accent text-xs underline hover:text-secondary transition-colors duration-300">
                                    CHECK EMI NOW
                                </button>
                            </div>
                        </div>

                        <!-- Delivery Check -->
                        <div class="mb-6">
                            <h3 class="text-secondary font-semibold mb-3">CHECK ESTIMATED DELIVERY</h3>
                            <div class="flex space-x-2">
                                <input type="text" placeholder="380016"
                                    class="flex-1 bg-gray-800 text-secondary px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-accent">
                                <button
                                    class="bg-accent text-primary px-6 py-2 rounded hover:bg-gray-300 transition-colors duration-300">
                                    CHECK
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 mb-6">
                            <button
                                class="add-to-cart-btn flex-1 bg-transparent border border-accent text-accent py-3 px-6 rounded hover:bg-accent hover:text-primary transition-colors duration-300">
                                ADD TO CART
                            </button>
                            <button
                                class="buy-now-btn flex-1 bg-accent text-primary py-3 px-6 rounded hover:bg-gray-300 transition-colors duration-300">
                                BUY IT NOW
                            </button>
                        </div>

                        <!-- Accordion Sections -->
                        <div class="space-y-2 text-left">
                            <!-- Description -->
                            <div class="border-b border-gray-700">
                                <button
                                    class="accordion-btn w-full flex justify-between items-center py-3 text-secondary font-semibold">
                                    <span>DESCRIPTION</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="accordion-content hidden pb-4 text-accent text-left">
                                    @if($product['description'])
                                        <p class="mb-3">{!! nl2br(e($product['description'])) !!}</p>
                                    @endif
                                    @if(isset($product['specifications']) && count($product['specifications']) > 0)
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach ($product['specifications'] as $spec)
                                                <li><strong>{{ $spec['name'] }}:</strong> {{ $spec['value'] }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>

                            <!-- Manufacturer Details -->
                            <div class="border-b border-gray-700">
                                <button
                                    class="accordion-btn w-full flex justify-between items-center py-3 text-secondary font-semibold">
                                    <span>MANUFACTURER DETAILS</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="accordion-content hidden pb-4 text-accent text-left">
                                    <p>Manufacturer: Fashion Store Pvt. Ltd.</p>
                                    <p>Country of Origin: India</p>
                                    <p>Care Instructions: Machine wash cold, tumble dry low</p>
                                </div>
                            </div>

                            <!-- Shipping, Return and Exchange -->
                            <div class="border-b border-gray-700">
                                <button
                                    class="accordion-btn w-full flex justify-between items-center py-3 text-secondary font-semibold">
                                    <span>SHIPPING, RETURN AND EXCHANGE</span>
                                    <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="accordion-content hidden pb-4 text-accent text-left">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Free shipping on all orders above ₹999.</li>
                                        <li>Standard delivery within 5–7 business days.</li>
                                        <li>Easy 7-day return and exchange policy.</li>
                                        <li>Items must be unused and in original packaging for returns.</li>
                                        <li>Refunds will be processed within 5–10 working days after inspection.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Size Selection Modal -->
        <div id="sizeModal" class="fixed inset-0 bg-black bg-opacity-70 z-50 hidden flex items-center justify-center p-4">
            <div class="bg-primary rounded-lg max-w-md w-full p-6">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-secondary mb-2">Product Options</h3>
                    <p class="text-accent">Please select required options before proceeding</p>
                </div>

                <!-- Attribute Groups with Titles -->
                <div class="space-y-6 mb-6 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                    @if(isset($product['attribute_groups']) && count($product['attribute_groups']) > 0)
                        @foreach($product['attribute_groups'] as $attributeName => $attributeGroup)
                            <div class="attribute-selection-block">
                                <h4 class="text-secondary font-semibold mb-3">{{ $attributeName }}</h4>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach ($attributeGroup['options'] as $option)
                                        <label class="inline-flex items-center cursor-pointer group" title="{{ $option['label'] }}">
                                            <input type="radio" name="modal-attribute-{{ $attributeName }}" value="{{ $option['value'] }}"
                                                class="hidden peer">
                                            @if(isset($attributeGroup['type']) && $attributeGroup['type'] === 'color')
                                                @php
                                                    $colorCode = $option['color_code'] ?? '';
                                                    if (empty($colorCode) && isset($option['label']) && (Str::startsWith($option['label'], '#') || preg_match('/^[a-fA-F0-9]{3,6}$/', $option['label']))) {
                                                        $colorCode = $option['label'];
                                                    }
                                                    if (empty($colorCode))
                                                        $colorCode = '#ccc';
                                                    if (!Str::startsWith($colorCode, '#') && !Str::startsWith($colorCode, 'rgb') && !Str::startsWith($colorCode, 'hsl')) {
                                                        $colorCode = '#' . $colorCode;
                                                    }
                                                    $hexVal = strtoupper(str_replace('#', '', $colorCode));
                                                    $isWhite = in_array($hexVal, ['FFFFFF', 'FFF', 'F9F9F9', 'F3F4F6', 'EEEEEE', 'E5E7EB']);
                                                    $isBlack = in_array($hexVal, ['000000', '000', '111111', '1F2937']);
                                                @endphp
                                                <span
                                                    class="w-12 h-12 rounded-full border-2 {{ $isWhite ? 'border-gray-300' : ($isBlack ? 'border-gray-700' : 'border-transparent') }} peer-checked:border-accent group-hover:scale-110 transition-all shadow-sm flex items-center justify-center relative"
                                                    style="background-color: {{ $colorCode }};">
                                                    <svg class="w-6 h-6 {{ $isWhite ? 'text-gray-900' : 'text-white' }} opacity-0 peer-checked:opacity-100 transition-opacity"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7">
                                                        </path>
                                                    </svg>
                                                </span>
                                            @else
                                                <span
                                                    class="w-full px-2 py-3 border border-accent text-accent rounded-md transition-all duration-300 peer-checked:bg-accent peer-checked:text-primary peer-checked:border-accent text-center text-sm font-medium">
                                                    {{ $option['label'] }}
                                                </span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Modal Buttons -->
                <div class="flex gap-3">
                    <button id="confirmSize"
                        class="flex-1 bg-accent text-primary py-3 px-6 rounded hover:bg-gray-300 transition-colors duration-300">
                        Confirm Size
                    </button>
                    <button id="closeSizeModal"
                        class="flex-1 bg-transparent border border-accent text-accent py-3 px-6 rounded hover:bg-accent hover:text-primary transition-colors duration-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Notification Container -->
        <div id="toastContainer"
            class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-[60] flex flex-col items-center gap-3 pointer-events-none">
        </div>
    </main>

    <!-- Fullscreen Image Modal -->
    <div id="fullscreenModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center">
        <div class="relative w-full h-full flex items-center justify-center">
            <button id="closeFullscreen"
                class="absolute top-4 right-4 text-white text-2xl z-10 bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">
                ✕
            </button>
            <button id="prevFullscreen"
                class="absolute left-4 text-white text-2xl z-10 bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">
                ‹
            </button>
            <button id="nextFullscreen"
                class="absolute right-4 text-white text-2xl z-10 bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center">
                ›
            </button>
            <img id="fullscreenImage" src="" alt="Fullscreen view" class="max-w-full max-h-full object-contain">
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .thumbnail {
            transition: all 0.3s ease;
        }

        .thumbnail:hover {
            transform: scale(1.05);
        }

        .quantity-btn:active {
            transform: scale(0.95);
        }

        /* Size selection styles */
        input[name="size"]:checked+span {
            background-color: #D1D5DB;
            color: #000000;
            border-color: #D1D5DB;
        }

        /* Carousel styles */
        .carousel-images {
            display: flex;
            transition: transform 0.3s ease-in-out;
        }

        .carousel-image {
            flex: 0 0 100%;
        }

        /* Hide carousel navigation on desktop */
        @media (min-width: 1024px) {
            .product-carousel {
                display: none;
            }
        }

        /* Show carousel on mobile and tablet */
        @media (max-width: 1023px) {
            .product-carousel {
                display: block;
            }
        }

        /* Toast Notification Styles */
        .toast-notification {
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 640px) {
            .toast-notification {
                min-width: 280px;
                max-width: calc(100vw - 2rem);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Change main image when thumbnail is clicked (desktop only)
        function changeMainImage(src) {
            const mainImage = document.getElementById('mainImage');
            if (mainImage) mainImage.src = src;
        }

        // Fullscreen image functionality
        let currentFullscreenIndex = 0;
        const productImages = @json(array_column($product['images'], 'url'));

        function openFullscreen(src) {
            currentFullscreenIndex = productImages.indexOf(src);
            const modal = document.getElementById('fullscreenModal');
            const fullscreenImage = document.getElementById('fullscreenImage');

            fullscreenImage.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeFullscreen() {
            const modal = document.getElementById('fullscreenModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        let isNavigating = false;
        function navigateFullscreen(direction) {
            if (isNavigating) return;
            isNavigating = true;
            setTimeout(() => { isNavigating = false; }, 300);

            if (direction === 'next') {
                currentFullscreenIndex = (currentFullscreenIndex + 1) % productImages.length;
            } else {
                currentFullscreenIndex = (currentFullscreenIndex - 1 + productImages.length) % productImages.length;
            }

            document.getElementById('fullscreenImage').src = productImages[currentFullscreenIndex];
        }


        // Initialize product image carousel for mobile and tablet
        function initializeProductImageCarousel() {
            const carousel = document.querySelector('.product-carousel');
            if (!carousel) return;

            const imagesContainer = carousel.querySelector('.carousel-images');
            const images = carousel.querySelectorAll('.carousel-image');
            const prevButton = carousel.querySelector('.carousel-prev');
            const nextButton = carousel.querySelector('.carousel-next');
            const indicators = carousel.querySelectorAll('.carousel-indicator');

            let currentIndex = 0;
            const totalImages = images.length;
            let startX = 0;
            let currentX = 0;
            let isDragging = false;

            function updateCarousel() {
                imagesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('active');
                        indicator.style.opacity = '1';
                    } else {
                        indicator.classList.remove('active');
                        indicator.style.opacity = '0.5';
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % totalImages;
                    updateCarousel();
                });
            }

            if (prevButton) {
                prevButton.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                    updateCarousel();
                });
            }

            // Touch events
            function handleTouchStart(e) {
                isDragging = true;
                startX = e.touches[0].clientX;
                currentX = startX;
                imagesContainer.style.transition = 'none';
            }

            function handleTouchMove(e) {
                if (!isDragging) return;
                currentX = e.touches[0].clientX;
                const diff = currentX - startX;
                const currentTranslate = -currentIndex * 100;
                const newTranslate = currentTranslate + (diff / carousel.offsetWidth) * 100;
                imagesContainer.style.transform = `translateX(${newTranslate}%)`;
            }

            function handleTouchEnd() {
                if (!isDragging) return;
                isDragging = false;
                imagesContainer.style.transition = 'transform 0.3s ease-in-out';

                const diff = currentX - startX;
                const threshold = carousel.offsetWidth * 0.15;

                if (Math.abs(diff) > threshold) {
                    if (diff > 0) {
                        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                    } else {
                        currentIndex = (currentIndex + 1) % totalImages;
                    }
                }
                updateCarousel();
            }

            carousel.addEventListener('touchstart', handleTouchStart, { passive: true });
            carousel.addEventListener('touchmove', handleTouchMove, { passive: true });
            carousel.addEventListener('touchend', handleTouchEnd, { passive: true });

            // Indicator click events
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    currentIndex = index;
                    updateCarousel();
                });
            });

            updateCarousel();
        }

        // Quantity control
        document.addEventListener('DOMContentLoaded', function () {
            const quantityDisplay = document.querySelector('.quantity-display');
            const quantityBtns = document.querySelectorAll('.quantity-btn');

            quantityBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    let quantity = parseInt(quantityDisplay.textContent);

                    if (this.dataset.action === 'increase') {
                        quantity++;
                    } else if (this.dataset.action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    quantityDisplay.textContent = quantity;
                });
            });

            // Size selection
            const sizeInputs = document.querySelectorAll('input[name="size"]');
            sizeInputs.forEach(input => {
                input.addEventListener('change', function () {
                    document.querySelectorAll('label').forEach(label => {
                        label.classList.remove('active');
                    });
                    this.parentElement.classList.add('active');
                });
            });

            // Accordion functionality
            const accordionBtns = document.querySelectorAll('.accordion-btn');
            accordionBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('svg');

                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');

                    accordionBtns.forEach(otherBtn => {
                        if (otherBtn !== this) {
                            otherBtn.nextElementSibling.classList.add('hidden');
                            otherBtn.querySelector('svg').classList.remove('rotate-180');
                        }
                    });
                });
            });

            // Fullscreen modal events
            document.getElementById('closeFullscreen')?.addEventListener('click', closeFullscreen);
            document.getElementById('prevFullscreen')?.addEventListener('click', () => navigateFullscreen('prev'));
            document.getElementById('nextFullscreen')?.addEventListener('click', () => navigateFullscreen('next'));

            // Close modal on background click
            document.getElementById('fullscreenModal')?.addEventListener('click', function (e) {
                if (e.target === this) {
                    closeFullscreen();
                }
            });

            // Initialize product image carousel
            initializeProductImageCarousel();

            // Size selection modal functionality
            let pendingAction = null; // To store which button was clicked

            function hasAttributes() {
                return @json(count($product['attribute_groups'] ?? []) > 0);
            }

            function areAllAttributesSelected() {
                if (!hasAttributes()) return true;

                const attributeGroups = @json(array_keys($product['attribute_groups'] ?? []));
                for (const group of attributeGroups) {
                    if (!document.querySelector(`input[name="attribute_${group}"]:checked`)) {
                        return false;
                    }
                }
                return true;
            }

            // Sync selected attributes to modal
            function syncAttributesToModal() {
                const attributeGroups = @json(array_keys($product['attribute_groups'] ?? []));
                attributeGroups.forEach(group => {
                    const mainSelected = document.querySelector(`input[name="attribute_${group}"]:checked`);
                    if (mainSelected) {
                        const modalInput = document.querySelector(`input[name="modal-attribute-${group}"][value="${mainSelected.value}"]`);
                        if (modalInput) modalInput.checked = true;
                    }
                });
            }

            function showSizeModal(action) {
                pendingAction = action;
                const modal = document.getElementById('sizeModal');
                if (modal) {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                    syncAttributesToModal();
                }
            }

            function hideSizeModal() {
                const modal = document.getElementById('sizeModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    pendingAction = null;
                }
            }

            function setAttributesFromModal() {
                const attributeGroups = @json(array_keys($product['attribute_groups'] ?? []));
                let allSelected = true;

                attributeGroups.forEach(group => {
                    const modalSelected = document.querySelector(`input[name="modal-attribute-${group}"]:checked`);
                    if (modalSelected) {
                        const value = modalSelected.value;
                        const mainInput = document.querySelector(`input[name="attribute_${group}"][value="${value}"]`);
                        if (mainInput) {
                            mainInput.checked = true;
                            mainInput.dispatchEvent(new Event('change'));
                        }
                    } else {
                        allSelected = false;
                    }
                });

                if (allSelected) {
                    const currentAction = pendingAction; // Keep track of action before hiding resets it
                    hideSizeModal();
                    pendingAction = currentAction;
                    executePendingAction();
                } else {
                    alert('Please select all options');
                }
            }

            function findMatchingVariant() {
                const variants = @json($product['variants'] ?? []);
                if (variants.length === 0) return null;

                // For simple products, just return the first variant
                if (!hasAttributes()) return variants[0].id;

                // For configurable products, match selected attributes
                const attributeGroups = @json(array_keys($product['attribute_groups'] ?? []));
                const selectedAttributes = {};
                attributeGroups.forEach(group => {
                    const input = document.querySelector(`input[name="attribute_${group}"]:checked`);
                    if (input) selectedAttributes[group.toLowerCase()] = input.value;
                });

                const matchingVariant = variants.find(variant => {
                    return variant.attributes.every(attr => {
                        const groupCode = (attr.attribute_code || '').toLowerCase();
                        return selectedAttributes[groupCode] === attr.value;
                    });
                });

                return matchingVariant ? matchingVariant.id : null;
            }

            async function executePendingAction() {
                const quantity = parseInt(document.querySelector('.quantity-display').textContent);
                const variantId = findMatchingVariant();
                const action = pendingAction; // Closure-safe action

                if (!variantId) {
                    showToast('Unable to find a product variant with the selected options.', 'error');
                    return;
                }

                try {
                    // Actual API Call
                    const response = await axios.post("{{ route('customer.cart.add') }}", {
                        variant_id: variantId,
                        quantity: quantity
                    });

                    if (response.data.success) {
                        showToast(`✓ Added ${quantity} item(s) to cart!`, 'success', 3000);

                        // Update header cart count if possible
                        updateCartCount(response.data.cart_count);

                        if (action === 'addToCart') {
                            setTimeout(() => {
                                if (typeof openCart === 'function') openCart();
                            }, 500);
                        } else if (action === 'buyNow') {
                            setTimeout(() => {
                                window.location.href = "{{ route('customer.checkout.index') }}";
                            }, 1000);
                        }
                    } else {
                        showToast(response.data.message || 'Failed to add to cart', 'error');
                    }
                } catch (error) {
                    console.error('Cart Error:', error);
                    const message = error.response?.data?.message || 'Something went wrong. Please try again.';
                    showToast(message, 'error');
                } finally {
                    pendingAction = null;
                }
            }

            function updateCartCount(count) {
                const countBadge = document.getElementById('cart-count-badge');
                if (countBadge) {
                    countBadge.textContent = count;
                }
            }

            // Action button event listeners
            const addToCartBtn = document.querySelector('.add-to-cart-btn');
            const buyNowBtn = document.querySelector('.buy-now-btn');

            addToCartBtn?.addEventListener('click', function () {
                pendingAction = 'addToCart';
                if (!areAllAttributesSelected()) {
                    showSizeModal('addToCart');
                } else {
                    executePendingAction();
                }
            });

            buyNowBtn?.addEventListener('click', function () {
                pendingAction = 'buyNow';
                if (!areAllAttributesSelected()) {
                    showSizeModal('buyNow');
                } else {
                    executePendingAction();
                }
            });

            // Modal event listeners
            document.getElementById('confirmSize')?.addEventListener('click', setAttributesFromModal);
            document.getElementById('closeSizeModal')?.addEventListener('click', hideSizeModal);

            // Close modal when clicking outside
            document.getElementById('sizeModal')?.addEventListener('click', function (e) {
                if (e.target === this) {
                    hideSizeModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    hideSizeModal();
                }
            });

            // Sync modal when main attributes change
            const attributeGroups = @json(array_keys($product['attribute_groups'] ?? []));
            attributeGroups.forEach(group => {
                const inputs = document.querySelectorAll(`input[name="attribute_${group}"]`);
                inputs.forEach(input => {
                    input.addEventListener('change', function () {
                        const modalInput = document.querySelector(`input[name="modal-attribute-${group}"][value="${this.value}"]`);
                        if (modalInput) {
                            modalInput.checked = true;
                        }
                    });
                });
            });
        });
    </script>
@endpush