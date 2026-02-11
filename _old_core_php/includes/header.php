<?php
// includes/header.php

// Include config
require_once __DIR__ . '/../config/config.php';

// Temporary fallback for demo: ensure $cartItems is always defined

if (!isset($cartItems) || !is_array($cartItems)) {
    $cartItems = [];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Fashion Store'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome CDN (Latest) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        secondary: '#FFFFFF',
                        // primary: '#FFFFFF',
                        // secondary: '#000000',
                        accent: '#D1D5DB',
                    }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <script>
        const baseUrl = "<?php echo BASE_URL; ?>";
    </script>

</head>

<body class="bg-primary text-secondary font-sans">
    <!-- Top Marquee -->
    <div class="bg-primary text-secondary py-2 overflow-hidden relative">
        <div class="animate-marquee whitespace-nowrap">
            <span class="mx-4">✨ Free shipping on orders over $50 ✨</span>
            <span class="mx-4">🎁 New collection just dropped! 🎁</span>
            <span class="mx-4">🔥 Limited time offer: 20% off hoodies 🔥</span>
            <span class="mx-4">✨ Free shipping on orders over $50 ✨</span>
            <span class="mx-4">🎁 New collection just dropped! 🎁</span>
            <span class="mx-4">🔥 Limited time offer: 20% off hoodies 🔥</span>
            <span class="mx-4">✨ Free shipping on orders over $50 ✨</span>
            <span class="mx-4">🎁 New collection just dropped! 🎁</span>
            <span class="mx-4">🔥 Limited time offer: 20% off hoodies 🔥</span>
        </div>
    </div>

    <!-- Main Header -->
    <header class="bg-primary text-secondary py-4 px-6 border-b border-gray-800">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Left: Navigation Links (Desktop) -->
            <nav class="hidden md:flex space-x-8">
                <a href="../products.php?category=hoodies"
                    class="hover:text-accent transition-colors duration-300">Hoodies</a>
                <a href="../products.php?category=tshirts"
                    class="hover:text-accent transition-colors duration-300">T-Shirts</a>
                <a href="../products.php?category=pants"
                    class="hover:text-accent transition-colors duration-300">Pants</a>
                <a href="../products.php?category=accessories"
                    class="hover:text-accent transition-colors duration-300">Accessories</a>
            </nav>

            <!-- Hamburger Menu (Mobile) -->
            <div class="md:hidden">
                <button id="hamburger" class="hamburger flex flex-col w-6 h-6 justify-between focus:outline-none">
                    <span class="hamburger-line w-full h-0.5 bg-secondary rounded"></span>
                    <span class="hamburger-line w-full h-0.5 bg-secondary rounded"></span>
                    <span class="hamburger-line w-full h-0.5 bg-secondary rounded"></span>
                </button>
            </div>

            <!-- Center: Logo -->
            <div class="flex-1 text-center md:flex-none lg:mr-48">
                <a href="<?php echo BASE_URL; ?>index.php" class="inline-block">
                    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt=" Logo" class="h-16 mx-auto">
                </a>
            </div>


            <!-- Right: Icons -->
            <div class="flex items-center space-x-6">
                <button class="hover:text-accent transition-colors duration-300 search-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <!-- Replace the existing heart icon button with this: -->
                <button onclick="openLoginModal()" class="hover:text-accent transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </button>
                <button onclick="openCart()" class="hover:text-accent transition-colors duration-300 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span
                        class="absolute -top-2 -right-2 bg-accent text-primary text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        <?php echo count($cartItems); ?>
                    </span>
                </button>

            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden mt-4 py-4 border-t border-gray-800 hidden">
            <nav class="flex flex-col space-y-4">
                <a href="../products.php?category=hoodies"
                    class="hover:text-accent transition-colors duration-300 py-2">Hoodies</a>
                <a href="../products.php?category=tshirts"
                    class="hover:text-accent transition-colors duration-300 py-2">T-Shirts</a>
                <a href="../products.php?category=pants"
                    class="hover:text-accent transition-colors duration-300 py-2">Pants</a>
                <a href="../products.php?category=accessories"
                    class="hover:text-accent transition-colors duration-300 py-2">Accessories</a>
            </nav>
        </div>
        <!-- Include Auth Modals -->
        <?php include BASE_PATH . 'includes/login-modal.php'; ?>
        <?php include BASE_PATH . 'includes/signup-modal.php'; ?>
        <!-- Search Bar -->
        <div id="search-bar" class="hidden mt-4">
            <div class="container mx-auto">
                <form action="../products.php" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Search products..."
                        class="flex-1 bg-gray-800 text-secondary px-4 py-2 rounded-l focus:outline-none focus:ring-2 focus:ring-accent">
                    <button type="submit"
                        class="bg-accent text-primary px-4 py-2 rounded-r hover:bg-gray-300 transition-colors duration-300">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </header>