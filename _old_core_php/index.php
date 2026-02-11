<?php
$pageTitle = "Home - Fashion Store";
require_once 'config/config.php';
include BASE_PATH . 'includes/header.php'; ?>

<main class="py-0">
    <!-- Hero Image Section -->
    <section class="w-full">
        <div class="container mx-auto px-6 py-12">
            <div class="flex justify-center items-center">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    alt="Fashion Collection" class="w-full max-w-6xl h-96 object-cover shadow-lg">
            </div>
        </div>
    </section>


    <!-- Breadcrumb Section -->
    <section class="bg-primary">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="<?php echo BASE_URL; ?>index.php"
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
                        <a href="products.php" class="ml-2 text-secondary transition-colors duration-300">Products</a>
                    </li>
                    <li class="flex items-center" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="ml-2 text-secondary">Featured Collection</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>


    <div class="container mx-auto">
        <h1 class="text-4xl font-bold mb-12 text-center">Featured Products</h1>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <!-- Product Card 3 -->
            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <a href="pages/product-detail.php?id=1">

                            <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                                <div class="carousel-image flex-shrink-0 w-full h-full">
                                    <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                        alt="Front View Shirt" class="w-full h-full object-cover" />
                                </div>
                                <div class="carousel-image flex-shrink-0 w-full h-full">
                                    <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                        alt="Back View Shirt" class="w-full h-full object-cover" />
                                </div>
                                <div class="carousel-image flex-shrink-0 w-full h-full">
                                    <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                        alt="Side View Shirt" class="w-full h-full object-cover" />
                                </div>
                            </div>
                        </a>
                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">A LUXURY HI FASHION DOUBLE
                        POCKET
                        CLUB SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">A LUXURY HI FASHION DOUBLE POCKET
                        CLUB SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">CHECKERED FORMAL SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">A LUXURY HI FASHION DOUBLE POCKET
                        CLUB SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">A LUXURY HI FASHION DOUBLE POCKET
                        CLUB SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">CHECKERED FORMAL SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div> <!-- Product Card 3 -->
            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">A LUXURY HI FASHION DOUBLE POCKET
                        CLUB SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>
            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">A LUXURY HI FASHION DOUBLE POCKET
                        CLUB SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>

            <!-- Product Card -->
            <div class="product-card bg-primary overflow-hidden group flex flex-col h-full">
                <div class="relative overflow-hidden flex-shrink-0">
                    <div class="product-carousel relative h-80 bg-gray-700">
                        <!-- Product Images -->
                        <div class="carousel-images flex transition-transform duration-500 ease-in-out h-full">
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274"
                                    alt="Front View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820"
                                    alt="Back View Shirt" class="w-full h-full object-cover" />
                            </div>
                            <div class="carousel-image flex-shrink-0 w-full h-full">
                                <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165"
                                    alt="Side View Shirt" class="w-full h-full object-cover" />
                            </div>
                        </div>

                        <!-- Navigation Buttons - Hidden on mobile -->
                        <button
                            class="carousel-nav carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button
                            class="carousel-nav carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden md:block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="product-title font-semibold mb-1 text-sm md:text-base">CHECKERED FORMAL SHIRT</h3>
                    <p class="product-variant text-secondary text-xs mb-3 flex-shrink-0">RED & BLACK</p>
                    <div class="price-container flex items-center space-x-2 mt-auto flex-shrink-0">
                        <span class="original-price text-secondary text-xs line-through">₹22,799</span>
                        <span class="discounted-price text-secondary text-sm">₹2,239</span>
                        <span class="discount-percent text-green-500 text-xs font-medium">20% </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


   <!-- Shop by Collection Section -->
<section class="py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Shop by Collection</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <!-- Card 1 -->
            <a href="products.php?category=hoodies" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://blacksilver.in/wp-content/uploads/2018/07/White-Hoodie-copy.png" 
                         alt="Hoodies" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Hoodies</p>
            </a>
            <!-- Card 2 -->
            <a href="products.php?category=tshirts" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="http://pngimg.com/uploads/tshirt/tshirt_PNG5450.png" 
                         alt="T-Shirts" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">T-Shirts</p>
            </a>
            <!-- Card 3 -->
            <a href="products.php?category=joggers" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://www.pngarts.com/files/3/Jogger-Pant-PNG-Download-Image.png" 
                         alt="Joggers" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Joggers</p>
            </a>
            <!-- Card 4 -->
            <a href="products.php?category=cordsets" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://i.pinimg.com/originals/3d/72/b0/3d72b022ead18e8411c0edd68dff429b.png" 
                         alt="Co-Ord Sets" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Co-Ord Sets</p>
            </a>
            <!-- Card 5 -->
            <a href="products.php?category=sweatshirts" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://i5.walmartimages.com/asr/49093c2c-f8ad-45a4-8c1a-b583c394d491_1.58dd1a7d1ea1ff52c06bf1afb9f9a0cf.jpeg" 
                         alt="Sweatshirts" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Sweatshirts</p>
            </a>
            <!-- Card 6 -->
            <a href="products.php?category=polos" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://png.pngtree.com/png-clipart/20230313/original/pngtree-realistic-white-t-shirt-vector-for-mockup-png-image_8987565.png" 
                         alt="Polos" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Polos</p>
            </a>


             <!-- Card 3 -->
            <a href="products.php?category=joggers" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://www.pngarts.com/files/3/Jogger-Pant-PNG-Download-Image.png" 
                         alt="Joggers" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Joggers</p>
            </a>
            <!-- Card 4 -->
            <a href="products.php?category=cordsets" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://i.pinimg.com/originals/3d/72/b0/3d72b022ead18e8411c0edd68dff429b.png" 
                         alt="Co-Ord Sets" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Co-Ord Sets</p>
            </a>
            <!-- Card 5 -->
            <a href="products.php?category=sweatshirts" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://i5.walmartimages.com/asr/49093c2c-f8ad-45a4-8c1a-b583c394d491_1.58dd1a7d1ea1ff52c06bf1afb9f9a0cf.jpeg" 
                         alt="Sweatshirts" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Sweatshirts</p>
            </a>
            <!-- Card 6 -->
            <a href="products.php?category=polos" class="flex flex-col items-center text-center group">
                <div class="w-full h-56 flex items-center justify-center  rounded-lg overflow-hidden">
                    <img src="https://png.pngtree.com/png-clipart/20230313/original/pngtree-realistic-white-t-shirt-vector-for-mockup-png-image_8987565.png" 
                         alt="Polos" class="object-contain h-full w-full">
                </div>
                <p class="mt-2 font-medium">Polos</p>
            </a>
        </div>
    </div>
</section>

<!-- Full 100vh Banner Section -->
<!-- <section class="relative w-full h-screen">
    <img src="https://images.unsplash.com/photo-1521334884684-d80222895322?auto=format&fit=crop&w=2000&q=80"
         alt="Fashion Banner"
         class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <h2 class="text-4xl md:text-6xl font-bold text-white">Discover Your Style</h2>
    </div>
</section> -->

<section class="w-full">
        <div class="container mx-auto px-6 py-12">
            <div class="flex justify-center items-center">
                <img src="https://marketplace.canva.com/EAFT4iBtkRY/1/0/800w/canva-beige-brown-minimalist-casual-style-banner-landscape-nCTDUarPDJo.jpg"
                    alt="Fashion Collection" class="w-full max-w-6xl h-96 object-cover shadow-lg">
            </div>
        </div>
    </section>

<!-- 50-50 Image Section -->
<section class="py-16">
    <div class="container mx-auto px-6 mb-10">
        <h2 class="text-3xl font-bold text-center mb-12">Explore More Collections</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 w-full">
        <!-- Left Image -->
        <div class="overflow-hidden">
            <img src="https://i.pinimg.com/originals/c5/09/e4/c509e4ba4842c831aa60eb3a3b0aba50.jpg"
                 alt="Men's Collection"
                 class="w-full h-full object-cover">
        </div>
        <!-- Right Image -->
        <div class="overflow-hidden">
            <img src="https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg"
                 alt="Women's Collection"
                 class="w-full h-full object-cover">
        </div>
    </div>
</section>

<!-- NEW ARRIVALS -->
    <section class="py-16 bg-primary text-secondary">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">New Arrivals</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="bg-primary p-4 rounded-lg text-center">
                        <img src="https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg" class="w-full h-60 object-cover mb-4 rounded">
                        <h4 class="font-semibold">Casual Shirt <?php echo $i; ?></h4>
                        <p class="text-sm text-gray-400">₹1,299</p>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- BEST SELLERS -->
    <section class="py-16">
        <div class="container mx-auto bg-primary text-secondary">
            <h2 class="text-3xl font-bold text-center mb-12">Best Sellers</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="p-4 border border-primary  text-center">
                        <img src="https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg" class="w-full h-60 object-cover mb-4 rounded">
                        <h4 class="font-semibold">Premium Tee <?php echo $i; ?></h4>
                        <p class="text-sm text-gray-400">₹999</p>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>
</main>

<?php include BASE_PATH . 'includes/footer.php'; ?>