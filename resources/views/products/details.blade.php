@extends('layouts.master')

@section('title', 'Product Details - Fashion Store')

@section('content')
@php
// In a real application, you would fetch product data from database based on product ID
$product = [
    'name' => 'REGULAR FIT PAISLEY PRINT SHIRT',
    'variant' => 'STROM - DARK BLUE',
    'original_price' => '₹2,999',
    'discounted_price' => '₹2,609',
    'discount_percent' => '13%',
    'description' => 'A regular fit paisley print shirt that combines comfort with style. Perfect for both casual and semi-formal occasions.',
    'features' => [
        'Regular fit for comfortable wear',
        'Paisley print design',
        'High-quality cotton fabric',
        'Machine washable'
    ],
    'sizes' => ['XS-36', 'S-38', 'M-40', 'L-42', 'XL-44', 'XXL-46', '3XL-46'],
    'images' => [
        'https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274',
        'https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820',
        'https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165',
        'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=688&q=80',
        'https://images.unsplash.com/photo-1621072156002-e2fccdc0b176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80',
        'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
        'https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165'
    ]
];
@endphp

<main class="py-8">
    <!-- Breadcrumb -->
    <section class="bg-primary mb-8">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                         <a href="{{ route('home') }}" class="text-secondary transition-colors duration-300 flex items-center">
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
                        <a href="{{ route('products.index') }}" class="ml-2 text-secondary transition-colors duration-300">Products</a>
                    </li>
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
                                    <img src="{{ $image }}" alt="Product image {{ $index + 1 }}"
                                        class="w-full h-96 object-cover rounded-lg cursor-pointer"
                                        onclick="openFullscreen('{{ $image }}')">
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation Buttons -->
                        <button
                            class="carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-primary bg-opacity-70 text-secondary p-2 rounded-full hover:bg-opacity-100 transition-all duration-300">
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
                                <img src="{{ $image }}" alt="Product image {{ $index + 1 }}"
                                    class="w-full h-full object-cover" onclick="openFullscreen('{{ $image }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Details - 40% on large, 50% on tablet, full width on mobile -->
            <div class="w-full md:w-1/2 lg:w-2/5 ">
                <div class="bg-primary rounded-lg p-6 sticky top-4 text-center">
                    <!-- Product Name -->
                    <h1 class="text-2xl font-bold text-secondary mb-2 text-center">{{ $product['name'] }}</h1>

                    <!-- Variant -->
                    <p class="text-accent text-lg mb-4 text-center">{{ $product['variant'] }}</p>

                    <!-- Price -->
                    <div class="flex items-center justify-center space-x-3 mb-4 ">
                        <span
                            class="text-secondary text-xl font-bold">{{ $product['discounted_price'] }}</span>
                        <span class="text-accent text-sm line-through">{{ $product['original_price'] }}</span>
                        <span class="text-green-500 text-sm font-medium bg-green-500 bg-opacity-20 px-2 py-1 rounded">
                            {{ $product['discount_percent'] }} OFF
                        </span>
                    </div>

                    <!-- Tax Info -->
                    <p class="text-accent text-sm mb-6 text-center">(Incl. of all taxes)</p>

                    <!-- Size Selection -->
                    <div class="mb-6 text-center">
                        <h3 class="text-secondary font-semibold mb-3 text-center">Size</h3>
                        <div class="flex flex-wrap gap-2 justify-center">
                            @foreach ($product['sizes'] as $size)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="size" value="{{ $size }}" class="hidden peer">
                                    <span
                                        class="px-4 py-2 border border-accent text-accent rounded-md cursor-pointer transition-all duration-300 peer-checked:bg-accent peer-checked:text-primary peer-checked:border-accent">
                                        {{ $size }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-6 text-center justify-center">
                        <h3 class="text-secondary font-semibold mb-3 text-center">Quantity</h3>
                        <div class="flex items-center space-x-3 justify-center">
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
                    <div class="mb-6 text-center">
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
                    <div class="space-y-2">
                        <!-- Description -->
                        <div class="border-b border-gray-700">
                            <button
                                class="accordion-btn w-full flex justify-between items-center py-3 text-secondary font-semibold text-left">
                                <span>DESCRIPTION</span>
                                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="accordion-content hidden pb-4 text-accent">
                                <p class="mb-3">{{ $product['description'] }}</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($product['features'] as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Manufacturer Details -->
                        <div class="border-b border-gray-700">
                            <button
                                class="accordion-btn w-full flex justify-between items-center py-3 text-secondary font-semibold text-left">
                                <span>MANUFACTURER DETAILS</span>
                                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="accordion-content hidden pb-4 text-accent">
                                <p>Manufacturer: Fashion Store Pvt. Ltd.</p>
                                <p>Country of Origin: India</p>
                                <p>Care Instructions: Machine wash cold, tumble dry low</p>
                            </div>
                        </div>

                        <!-- Shipping, Return and Exchange -->
                        <div class="border-b border-gray-700">
                            <button
                                class="accordion-btn w-full flex justify-between items-center py-3 text-secondary font-semibold text-left">
                                <span>SHIPPING, RETURN AND EXCHANGE</span>
                                <svg class="w-5 h-5 transform transition-transform duration-300" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="accordion-content hidden pb-4 text-accent">
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
                <h3 class="text-xl font-bold text-secondary mb-2">Select Size</h3>
                <p class="text-accent">Please select a size before proceeding</p>
            </div>

            <!-- Size Options -->
            <div class="grid grid-cols-3 gap-3 mb-6">
                @foreach ($product['sizes'] as $size)
                    <label class="inline-flex items-center">
                        <input type="radio" name="modal-size" value="{{ $size }}" class="hidden peer">
                        <span
                            class="w-full px-4 py-3 border border-accent text-accent rounded-md cursor-pointer transition-all duration-300 peer-checked:bg-accent peer-checked:text-primary peer-checked:border-accent text-center">
                            {{ $size }}
                        </span>
                    </label>
                @endforeach
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
    <div id="toastContainer" class="fixed bottom-8 left-1/2 transform -translate-x-1/2 z-[60] flex flex-col items-center gap-3 pointer-events-none">
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
    // Toast Notification System
    function showToast(message, type = 'success', duration = 3000) {
        const container = document.getElementById('toastContainer');
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification pointer-events-auto transform transition-all duration-300 ease-out opacity-0 translate-y-4 ${
            type === 'success' ? 'bg-green-600' : 'bg-red-600'
        } text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] max-w-md`;
        
        // Icon based on type
        const icon = type === 'success' 
            ? `<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
               </svg>`
            : `<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
               </svg>`;
        
        toast.innerHTML = `
            ${icon}
            <span class="flex-1 font-medium">${message}</span>
            <button onclick="this.parentElement.remove()" class="hover:bg-white hover:bg-opacity-20 rounded p-1 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        container.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('opacity-0', 'translate-y-4');
        }, 10);
        
        // Auto remove after duration
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }

    // Change main image when thumbnail is clicked (desktop only)
    function changeMainImage(src) {
        const mainImage = document.getElementById('mainImage');
        if (mainImage) mainImage.src = src;
    }

    // Fullscreen image functionality
    let currentFullscreenIndex = 0;
    const productImages = @json($product['images']);

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

        function showSizeModal(action) {
            pendingAction = action;
            const modal = document.getElementById('sizeModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Sync selected size
                const mainSelectedSize = document.querySelector('input[name="size"]:checked');
                if (mainSelectedSize) {
                    const modalInput = document.querySelector(`input[name="modal-size"][value="${mainSelectedSize.value}"]`);
                    if (modalInput) modalInput.checked = true;
                }
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

        function getSelectedSize() {
            const selectedSize = document.querySelector('input[name="size"]:checked');
            return selectedSize ? selectedSize.value : null;
        }

        function setSizeFromModal() {
            const modalSelectedSize = document.querySelector('input[name="modal-size"]:checked');
            if (modalSelectedSize) {
                const sizeValue = modalSelectedSize.value;

                // Update the main size selection
                const mainSizeInput = document.querySelector(`input[name="size"][value="${sizeValue}"]`);
                if (mainSizeInput) {
                    mainSizeInput.checked = true;
                    mainSizeInput.dispatchEvent(new Event('change'));
                }

                hideSizeModal();
                executePendingAction();
            } else {
                alert('Please select a size');
            }
        }

        function executePendingAction() {
            const quantity = parseInt(document.querySelector('.quantity-display').textContent);
            
            if (pendingAction === 'addToCart') {
                // Show success toast
                showToast(`✓ Added ${quantity} item(s) to cart!`, 'success', 3000);
                
                // Open cart drawer after a short delay
                setTimeout(() => {
                    if (typeof openCart === 'function') {
                        openCart();
                    }
                }, 500);
            } else if (pendingAction === 'buyNow') {
                // Add to cart and redirect to checkout
                showToast(`✓ Added ${quantity} item(s) to cart!`, 'success', 2000);
                
                // Redirect to checkout after showing toast
                setTimeout(() => {
                    window.location.href = "{{ route('checkout.index') }}";
                }, 2000);
            }
        }

        // Size modal functionality
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const buyNowBtn = document.querySelector('.buy-now-btn');


        addToCartBtn?.addEventListener('click', function () {
            const selectedSize = getSelectedSize();
            if (!selectedSize) {
                showSizeModal('addToCart');
            } else {
                // Add to cart logic here
                const quantity = parseInt(document.querySelector('.quantity-display').textContent);
                
                // Show success toast
                showToast(`✓ Added ${quantity} item(s) to cart!`, 'success', 3000);
                
                // Open cart drawer after a short delay
                setTimeout(() => {
                    if (typeof openCart === 'function') {
                        openCart();
                    }
                }, 500);
            }
        });

        buyNowBtn?.addEventListener('click', function () {
            const selectedSize = getSelectedSize();
            if (!selectedSize) {
                showSizeModal('buyNow');
            } else {
                // Add to cart and redirect to checkout
                const quantity = parseInt(document.querySelector('.quantity-display').textContent);
                showToast(`✓ Added ${quantity} item(s) to cart!`, 'success', 2000);
                
                // Redirect to checkout after showing toast
                setTimeout(() => {
                    window.location.href = "{{ route('checkout.index') }}";
                }, 2000);
            }
        });


        // Modal event listeners
        document.getElementById('confirmSize')?.addEventListener('click', setSizeFromModal);
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

        // Update modal size selection when main size is selected
        const sizeRadios = document.querySelectorAll('input[name="size"]');
        sizeRadios.forEach(input => {
            input.addEventListener('change', function () {
                // Also update the modal selection
                const modalSizeInput = document.querySelector(`input[name="modal-size"][value="${this.value}"]`);
                if (modalSizeInput) {
                    modalSizeInput.checked = true;
                }
            });
        });
    });
</script>
@endpush
