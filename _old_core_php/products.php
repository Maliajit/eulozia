<?php
require_once __DIR__ . '/config/config.php';
$pageTitle = "Products - Fashion Store";
include BASE_PATH . 'includes/header.php';

// Get category from URL
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$categoryName = ucfirst($category);

// Sample product data (in real app, this would come from database)
$products = [
    [
        'id' => 1,
        'name' => 'Oversized Cotton T-Shirt',
        'price' => 1999,
        'discounted_price' => 1499,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Urban Classic',
        'sizes' => ['S', 'M', 'L', 'XL'],
        'colors' => ['Black', 'White', 'Gray'],
        'material' => 'Cotton',
        'sleeve_length' => 'Full',
        'fit_type' => 'Oversized',
        'pattern' => 'Solid',
        'style' => 'Casual',
        'rating' => 4.5,
        'in_stock' => true,
        'gender' => 'Unisex'
    ],
    [
        'id' => 31,
        'name' => 'Oversized Cotton T-Shirt',
        'price' => 1999,
        'discounted_price' => 1499,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Urban Classic',
        'sizes' => ['S', 'M', 'L', 'XL'],
        'colors' => ['Black', 'White', 'Gray'],
        'material' => 'Cotton',
        'sleeve_length' => 'Full',
        'fit_type' => 'Oversized',
        'pattern' => 'Solid',
        'style' => 'Casual',
        'rating' => 4.5,
        'in_stock' => true,
        'gender' => 'Unisex'
    ],
    [
        'id' => 18,
        'name' => 'Oversized Cotton T-Shirt',
        'price' => 1999,
        'discounted_price' => 1499,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Urban Classic',
        'sizes' => ['S', 'M', 'L', 'XL'],
        'colors' => ['Black', 'White', 'Gray'],
        'material' => 'Cotton',
        'sleeve_length' => 'Full',
        'fit_type' => 'Oversized',
        'pattern' => 'Solid',
        'style' => 'Casual',
        'rating' => 4.5,
        'in_stock' => true,
        'gender' => 'Unisex'
    ],
    [
        'id' => 2,
        'name' => 'Slim Fit Denim Jeans',
        'price' => 3999,
        'discounted_price' => 2999,
        'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Denim Co',
        'sizes' => ['28', '30', '32', '34'],
        'colors' => ['Blue', 'Black'],
        'material' => 'Denim',
        'sleeve_length' => 'Full',
        'fit_type' => 'Slim',
        'pattern' => 'Solid',
        'style' => 'Casual',
        'rating' => 4.2,
        'in_stock' => true,
        'gender' => 'Men'
    ],
    [
        'id' => 3,
        'name' => 'Floral Print Summer Dress',
        'price' => 2999,
        'discounted_price' => 1999,
        'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Summer Bliss',
        'sizes' => ['XS', 'S', 'M'],
        'colors' => ['Pink', 'Yellow', 'White'],
        'material' => 'Polyester',
        'sleeve_length' => 'Sleeveless',
        'fit_type' => 'Regular',
        'pattern' => 'Printed',
        'style' => 'Casual',
        'rating' => 4.7,
        'in_stock' => true,
        'gender' => 'Women'
    ],
    [
        'id' => 4,
        'name' => 'Formal Linen Shirt',
        'price' => 2499,
        'discounted_price' => 1999,
        'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Executive Wear',
        'sizes' => ['M', 'L', 'XL'],
        'colors' => ['White', 'Blue'],
        'material' => 'Linen',
        'sleeve_length' => 'Full',
        'fit_type' => 'Regular',
        'pattern' => 'Solid',
        'style' => 'Formal',
        'rating' => 4.3,
        'in_stock' => false,
        'gender' => 'Men'
    ],
    [
        'id' => 5,
        'name' => 'Kids Printed T-Shirt',
        'price' => 999,
        'discounted_price' => 799,
        'image' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Kids World',
        'sizes' => ['XS', 'S'],
        'colors' => ['Red', 'Blue', 'Green'],
        'material' => 'Cotton',
        'sleeve_length' => 'Half',
        'fit_type' => 'Regular',
        'pattern' => 'Printed',
        'style' => 'Casual',
        'rating' => 4.6,
        'in_stock' => true,
        'gender' => 'Kids'
    ],
    [
        'id' => 6,
        'name' => 'Wool Blend Sweater',
        'price' => 4999,
        'discounted_price' => 3999,
        'image' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
        'brand' => 'Winter Comfort',
        'sizes' => ['S', 'M', 'L', 'XL'],
        'colors' => ['Gray', 'Navy', 'Burgundy'],
        'material' => 'Wool',
        'sleeve_length' => 'Full',
        'fit_type' => 'Regular',
        'pattern' => 'Solid',
        'style' => 'Casual',
        'rating' => 4.4,
        'in_stock' => true,
        'gender' => 'Unisex'
    ]
];

// Extract unique values for filters
$brands = array_unique(array_column($products, 'brand'));
$materials = array_unique(array_column($products, 'material'));
$sleeveLengths = array_unique(array_column($products, 'sleeve_length'));
$fitTypes = array_unique(array_column($products, 'fit_type'));
$patterns = array_unique(array_column($products, 'pattern'));
$styles = array_unique(array_column($products, 'style'));
$genders = array_unique(array_column($products, 'gender'));

// Collect all sizes and colors
$allSizes = [];
$allColors = [];
foreach ($products as $product) {
    $allSizes = array_merge($allSizes, $product['sizes']);
    $allColors = array_merge($allColors, $product['colors']);
}
$sizes = array_unique($allSizes);
$colors = array_unique($allColors);
sort($sizes);
?>

<main class="py-8">
    <!-- Breadcrumb -->
    <section class="bg-primary mb-8">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="index.php" class="text-secondary transition-colors duration-300 flex items-center">
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
                        <span class="ml-2 text-secondary"><?php echo $categoryName; ?></span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container mx-auto px-4">
        <!-- Mobile Filter Button -->
        <div class="lg:hidden flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold text-secondary"><?php echo $categoryName; ?> Collection</h1>
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
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-secondary">Filters</h2>
                        <button id="clearAllFilters"
                            class="text-accent text-sm hover:text-secondary transition-colors duration-300">
                            Clear All
                        </button>
                    </div>

                    <!-- Filter Sections -->
                    <div class="space-y-6">
                        <!-- Gender Filter -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Gender
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($genders as $gender): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="gender" value="<?php echo strtolower($gender); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $gender; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Price Range
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="mb-4">
                                    <input type="range" id="priceRange" min="0" max="10000" step="100"
                                        class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                                    <div class="flex justify-between text-accent text-sm mt-2">
                                        <span>₹0</span>
                                        <span>₹10,000</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <button
                                        class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                        data-min="0" data-max="999">Under ₹999</button>
                                    <button
                                        class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                        data-min="1000" data-max="1999">₹1k-₹2k</button>
                                    <button
                                        class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                        data-min="2000" data-max="2999">₹2k-₹3k</button>
                                    <button
                                        class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                        data-min="3000" data-max="10000">Above ₹3k</button>
                                </div>
                            </div>
                        </div>

                        <!-- Brand Filter -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Brand
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2 max-h-48 overflow-y-auto">
                                    <?php foreach ($brands as $brand): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="brand" value="<?php echo strtolower($brand); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $brand; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Size Filter -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Size
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="grid grid-cols-3 gap-2">
                                    <?php foreach ($sizes as $size): ?>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="size" value="<?php echo $size; ?>"
                                                class="filter-checkbox hidden peer">
                                            <span
                                                class="w-full px-3 py-2 border border-accent text-accent rounded text-sm text-center cursor-pointer transition-all duration-300 peer-checked:bg-accent peer-checked:text-primary peer-checked:border-accent">
                                                <?php echo $size; ?>
                                            </span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>


                        <!-- Color Filter -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Color
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="grid grid-cols-4 gap-2">
                                    <?php
                                    $colorMap = [
                                        'Black' => '#000000',
                                        'White' => '#FFFFFF',
                                        'Gray' => '#6B7280',
                                        'Blue' => '#3B82F6',
                                        'Red' => '#EF4444',
                                        'Green' => '#10B981',
                                        'Yellow' => '#F59E0B',
                                        'Pink' => '#EC4899',
                                        'Purple' => '#8B5CF6',
                                        'Navy' => '#1E3A8A',
                                        'Burgundy' => '#831843'
                                    ];
                                    foreach ($colors as $color):
                                        $colorCode = $colorMap[$color] ?? '#6B7280';
                                        ?>
                                        <label class="inline-flex items-center justify-center">
                                            <input type="checkbox" name="color" value="<?php echo strtolower($color); ?>"
                                                class="filter-checkbox hidden peer">
                                            <span
                                                class="w-8 h-8 rounded-full border-2 border-gray-600 cursor-pointer transition-all duration-300 peer-checked:border-accent"
                                                style="background-color: <?php echo $colorCode; ?>"></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Material Filter -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Material
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($materials as $material): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="material"
                                                value="<?php echo strtolower($material); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $material; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sleeve Length -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Sleeve Length
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($sleeveLengths as $sleeve): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="sleeve_length"
                                                value="<?php echo strtolower($sleeve); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $sleeve; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Fit Type -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Fit Type
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($fitTypes as $fit): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="fit_type" value="<?php echo strtolower($fit); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $fit; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Pattern -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Pattern
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($patterns as $pattern): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="pattern"
                                                value="<?php echo strtolower($pattern); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $pattern; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Style -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Style
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($styles as $style): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="style" value="<?php echo strtolower($style); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $style; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Discount -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Discount
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="10"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">10% and above</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="20"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">20% and above</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="30"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">30% and above</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="40"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">40% and above</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Availability
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="availability" value="in_stock"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">In Stock</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="availability" value="out_of_stock"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">Out of Stock</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Customer Rating
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php for ($i = 4; $i >= 1; $i--): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="rating" value="<?php echo $i; ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm flex items-center">
                                                <?php for ($j = 1; $j <= 5; $j++): ?>
                                                    <svg class="w-4 h-4 <?php echo $j <= $i ? 'text-yellow-400' : 'text-gray-600'; ?>"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                <?php endfor; ?>
                                                & above
                                            </span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid - 75% -->
            <div class="w-full lg:w-3/4">
                <!-- Desktop Header -->
                <div class="bg-primary rounded-lg p-6 mb-6 hidden lg:block">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-secondary mb-2"><?php echo $categoryName; ?> Collection
                            </h1>
                            <p class="text-accent">Showing <span
                                    id="productCount"><?php echo count($products); ?></span> products</p>
                        </div>
                        <div class="flex items-center space-x-4 mt-4 lg:mt-0">
                            <div class="flex items-center space-x-2">
                                <span class="text-accent text-sm">Sort by:</span>
                                <select id="sortBy"
                                    class="bg-gray-800 text-secondary px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-accent">
                                    <option value="featured">Featured</option>
                                    <option value="price_low">Price: Low to High</option>
                                    <option value="price_high">Price: High to Low</option>
                                    <option value="newest">Newest First</option>
                                    <option value="rating">Customer Rating</option>
                                    <option value="discount">Best Discount</option>
                                </select>
                            </div>
                            <div class="hidden lg:flex items-center space-x-2">
                                <button id="gridView"
                                    class="p-2 rounded hover:bg-gray-800 transition-colors duration-300 text-secondary">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </button>
                                <button id="listView"
                                    class="p-2 rounded hover:bg-gray-800 transition-colors duration-300 text-accent">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="productsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card bg-primary rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300"
                            data-product='<?php echo json_encode($product); ?>'>
                            <div class="relative">
                                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>"
                                    class="w-full h-64 object-cover">
                                <?php if ($product['discounted_price'] < $product['price']): ?>
                                    <div
                                        class="absolute top-2 left-2 bg-red-600 text-secondary px-2 py-1 rounded text-sm font-semibold">
                                        <?php echo round((($product['price'] - $product['discounted_price']) / $product['price']) * 100); ?>%
                                        OFF
                                    </div>
                                <?php endif; ?>
                                <?php if (!$product['in_stock']): ?>
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="bg-gray-800 text-accent px-3 py-1 rounded text-sm">Out of Stock</span>
                                    </div>
                                <?php endif; ?>
                                <button
                                    class="absolute top-2 right-2 bg-primary bg-opacity-70 text-secondary p-2 rounded-full hover:bg-opacity-100 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <h3 class="text-secondary font-semibold mb-2 truncate"><?php echo $product['name']; ?></h3>
                                <p class="text-accent text-sm mb-2"><?php echo $product['brand']; ?></p>
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <svg class="w-4 h-4 <?php echo $i <= floor($product['rating']) ? 'text-yellow-400' : 'text-gray-600'; ?>"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php endfor; ?>
                                        <span class="text-accent text-sm ml-1">(<?php echo $product['rating']; ?>)</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="text-secondary font-bold text-lg">₹<?php echo number_format($product['discounted_price']); ?></span>
                                        <?php if ($product['discounted_price'] < $product['price']): ?>
                                            <span
                                                class="text-accent text-sm line-through">₹<?php echo number_format($product['price']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <button
                                        class="bg-accent text-primary px-4 py-2 rounded hover:bg-gray-300 transition-colors duration-300 <?php echo !$product['in_stock'] ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                                        <?php echo !$product['in_stock'] ? 'disabled' : ''; ?>>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="hidden text-center py-12">
                    <svg class="w-16 h-16 text-accent mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-secondary mb-2">No products found</h3>
                    <p class="text-accent mb-4">Try adjusting your filters to find what you're looking for.</p>
                    <button id="resetFilters"
                        class="bg-accent text-primary px-6 py-2 rounded hover:bg-gray-300 transition-colors duration-300">
                        Reset All Filters
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Mobile Filter Sidebar -->
<div id="mobileFilterSidebar" class="fixed inset-0 z-50 hidden lg:hidden">
    <!-- Overlay -->
    <div id="mobileFilterOverlay" class="absolute inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Sidebar -->
    <div class="absolute left-0 top-0 h-full w-4/5 max-w-sm bg-primary overflow-y-auto transform transition-transform duration-300 -translate-x-full">
        <div class="p-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-secondary">Filters</h2>
                <button id="closeMobileFilters" class="text-secondary hover:text-accent transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            
            <!-- Mobile Filter Content -->
            <div class="space-y-6">
                <!-- Gender Filter -->
                <div class="filter-section">
                    <h3
                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                        Gender
                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </h3>
                    <div class="filter-content hidden">
                        <div class="space-y-2">
                            <?php foreach ($genders as $gender): ?>
                                <label class="flex items-center">
                                    <input type="checkbox" name="gender" value="<?php echo strtolower($gender); ?>"
                                        class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                    <span class="ml-2 text-accent text-sm"><?php echo $gender; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="filter-section">
                    <h3
                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                        Price Range
                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </h3>
                    <div class="filter-content hidden">
                        <div class="mb-4">
                            <input type="range" id="mobilePriceRange" min="0" max="10000" step="100"
                                class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer">
                            <div class="flex justify-between text-accent text-sm mt-2">
                                <span>₹0</span>
                                <span>₹10,000</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button
                                class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                data-min="0" data-max="999">Under ₹999</button>
                            <button
                                class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                data-min="1000" data-max="1999">₹1k-₹2k</button>
                            <button
                                class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                data-min="2000" data-max="2999">₹2k-₹3k</button>
                            <button
                                class="price-preset text-accent text-sm bg-gray-800 py-2 rounded hover:bg-gray-700 transition-colors duration-300"
                                data-min="3000" data-max="10000">Above ₹3k</button>
                        </div>
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="filter-section">
                    <h3
                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                        Brand
                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </h3>
                    <div class="filter-content hidden">
                        <div class="space-y-2 max-h-48 overflow-y-auto">
                            <?php foreach ($brands as $brand): ?>
                                <label class="flex items-center">
                                    <input type="checkbox" name="brand" value="<?php echo strtolower($brand); ?>"
                                        class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                    <span class="ml-2 text-accent text-sm"><?php echo $brand; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Size Filter -->
                <div class="filter-section">
                    <h3
                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                        Size
                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </h3>
                    <div class="filter-content hidden">
                        <div class="grid grid-cols-3 gap-2">
                            <?php foreach ($sizes as $size): ?>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="size" value="<?php echo $size; ?>"
                                        class="filter-checkbox hidden peer">
                                    <span
                                        class="w-full px-3 py-2 border border-accent text-accent rounded text-sm text-center cursor-pointer transition-all duration-300 peer-checked:bg-accent peer-checked:text-primary peer-checked:border-accent">
                                        <?php echo $size; ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Color Filter -->
                <div class="filter-section">
                    <h3
                        class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                        Color
                        <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </h3>
                    <div class="filter-content hidden">
                        <div class="grid grid-cols-4 gap-2">
                            <?php
                            $colorMap = [
                                'Black' => '#000000',
                                'White' => '#FFFFFF',
                                'Gray' => '#6B7280',
                                'Blue' => '#3B82F6',
                                'Red' => '#EF4444',
                                'Green' => '#10B981',
                                'Yellow' => '#F59E0B',
                                'Pink' => '#EC4899',
                                'Purple' => '#8B5CF6',
                                'Navy' => '#1E3A8A',
                                'Burgundy' => '#831843'
                            ];
                            foreach ($colors as $color):
                                $colorCode = $colorMap[$color] ?? '#6B7280';
                                ?>
                                <label class="inline-flex items-center justify-center">
                                    <input type="checkbox" name="color" value="<?php echo strtolower($color); ?>"
                                        class="filter-checkbox hidden peer">
                                    <span
                                        class="w-8 h-8 rounded-full border-2 border-gray-600 cursor-pointer transition-all duration-300 peer-checked:border-accent"
                                        style="background-color: <?php echo $colorCode; ?>"></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
   <!-- Material Filter -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Material
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($materials as $material): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="material"
                                                value="<?php echo strtolower($material); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $material; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sleeve Length -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Sleeve Length
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($sleeveLengths as $sleeve): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="sleeve_length"
                                                value="<?php echo strtolower($sleeve); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $sleeve; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Fit Type -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Fit Type
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($fitTypes as $fit): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="fit_type" value="<?php echo strtolower($fit); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $fit; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Pattern -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Pattern
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($patterns as $pattern): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="pattern"
                                                value="<?php echo strtolower($pattern); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $pattern; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Style -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Style
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php foreach ($styles as $style): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="style" value="<?php echo strtolower($style); ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm"><?php echo $style; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Discount -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Discount
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="10"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">10% and above</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="20"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">20% and above</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="30"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">30% and above</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="discount" value="40"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">40% and above</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Availability
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="availability" value="in_stock"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">In Stock</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="availability" value="out_of_stock"
                                            class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                        <span class="ml-2 text-accent text-sm">Out of Stock</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="filter-section">
                            <h3
                                class="text-secondary font-semibold mb-3 flex justify-between items-center cursor-pointer filter-toggle">
                                Customer Rating
                                <svg class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </h3>
                            <div class="filter-content hidden">
                                <div class="space-y-2">
                                    <?php for ($i = 4; $i >= 1; $i--): ?>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="rating" value="<?php echo $i; ?>"
                                                class="filter-checkbox rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                                            <span class="ml-2 text-accent text-sm flex items-center">
                                                <?php for ($j = 1; $j <= 5; $j++): ?>
                                                    <svg class="w-4 h-4 <?php echo $j <= $i ? 'text-yellow-400' : 'text-gray-600'; ?>"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                <?php endfor; ?>
                                                & above
                                            </span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                <!-- Apply Filters Button -->
                <div class="sticky bottom-0 bg-primary pt-4 pb-2">
                    <button id="applyMobileFilters"
                        class="w-full bg-accent text-primary py-3 rounded font-semibold hover:bg-gray-300 transition-colors duration-300">
                        Apply Filters
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    // Product data from PHP
    const allProducts = <?php echo json_encode($products); ?>;
    let filteredProducts = [...allProducts];
    let currentView = 'grid';

    // DOM Elements
    const productsContainer = document.getElementById('productsContainer');
    const productCount = document.getElementById('productCount');
    const noResults = document.getElementById('noResults');
    const clearAllFilters = document.getElementById('clearAllFilters');
    const resetFilters = document.getElementById('resetFilters');
    const sortBy = document.getElementById('sortBy');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const mobileFilterSidebar = document.getElementById('mobileFilterSidebar');
    const mobileFilterOverlay = document.getElementById('mobileFilterOverlay');
    const closeMobileFilters = document.getElementById('closeMobileFilters');
    const applyMobileFilters = document.getElementById('applyMobileFilters');

    // Filter state
    const filters = {
        gender: [],
        price: { min: 0, max: 10000 },
        brand: [],
        size: [],
        color: [],
        material: [],
        sleeve_length: [],
        fit_type: [],
        pattern: [],
        style: [],
        discount: [],
        availability: [],
        rating: []
    };

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        initializeFilters();
        setupEventListeners();
        renderProducts();
    });

    function setupEventListeners() {
        // Filter checkboxes
        document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const filterType = this.name;
                const value = this.value;

                if (this.checked) {
                    if (!filters[filterType].includes(value)) {
                        filters[filterType].push(value);
                    }
                } else {
                    filters[filterType] = filters[filterType].filter(item => item !== value);
                }

                applyFilters();
            });
        });

        // Price range
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.addEventListener('input', function () {
                filters.price.min = 0;
                filters.price.max = parseInt(this.value);
                applyFilters();
            });
        }

        // Mobile price range
        const mobilePriceRange = document.getElementById('mobilePriceRange');
        if (mobilePriceRange) {
            mobilePriceRange.addEventListener('input', function () {
                filters.price.min = 0;
                filters.price.max = parseInt(this.value);
            });
        }

        // Price preset buttons
        document.querySelectorAll('.price-preset').forEach(button => {
            button.addEventListener('click', function () {
                filters.price.min = parseInt(this.dataset.min);
                filters.price.max = parseInt(this.dataset.max);
                applyFilters();
                
                // Update mobile price range slider
                if (mobilePriceRange) {
                    mobilePriceRange.value = filters.price.max;
                }
            });
        });

        // Clear all filters
        if (clearAllFilters) {
            clearAllFilters.addEventListener('click', clearAllFiltersHandler);
        }

        // Reset filters
        if (resetFilters) {
            resetFilters.addEventListener('click', clearAllFiltersHandler);
        }

        // Sort by
        if (sortBy) {
            sortBy.addEventListener('change', applySorting);
        }

        // View toggle
        if (gridView && listView) {
            gridView.addEventListener('click', () => switchView('grid'));
            listView.addEventListener('click', () => switchView('list'));
        }

        // Mobile filter toggle
        if (mobileFilterToggle) {
            mobileFilterToggle.addEventListener('click', openMobileFilters);
        }

        // Close mobile filters
        if (closeMobileFilters) {
            closeMobileFilters.addEventListener('click', closeMobileFiltersHandler);
        }

        // Apply mobile filters
        if (applyMobileFilters) {
            applyMobileFilters.addEventListener('click', function() {
                applyFilters();
                closeMobileFiltersHandler();
            });
        }

        // Close mobile filters when clicking overlay
        if (mobileFilterOverlay) {
            mobileFilterOverlay.addEventListener('click', closeMobileFiltersHandler);
        }
    }

    function initializeFilters() {
        // Set up filter toggle functionality
        document.querySelectorAll('.filter-toggle').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const content = this.nextElementSibling;
                const icon = this.querySelector('svg');

                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    }

    function applyFilters() {
        filteredProducts = allProducts.filter(product => {
            // Gender filter
            if (filters.gender.length > 0 && !filters.gender.includes(product.gender.toLowerCase())) {
                return false;
            }

            // Price filter
            if (product.discounted_price < filters.price.min || product.discounted_price > filters.price.max) {
                return false;
            }

            // Brand filter
            if (filters.brand.length > 0 && !filters.brand.includes(product.brand.toLowerCase())) {
                return false;
            }

            // Size filter
            if (filters.size.length > 0 && !filters.size.some(size => product.sizes.includes(size))) {
                return false;
            }

            // Color filter
            if (filters.color.length > 0 && !filters.color.some(color => product.colors.map(c => c.toLowerCase()).includes(color))) {
                return false;
            }

            // Material filter
            if (filters.material.length > 0 && !filters.material.includes(product.material.toLowerCase())) {
                return false;
            }

            // Sleeve length filter
            if (filters.sleeve_length.length > 0 && !filters.sleeve_length.includes(product.sleeve_length.toLowerCase())) {
                return false;
            }

            // Fit type filter
            if (filters.fit_type.length > 0 && !filters.fit_type.includes(product.fit_type.toLowerCase())) {
                return false;
            }

            // Pattern filter
            if (filters.pattern.length > 0 && !filters.pattern.includes(product.pattern.toLowerCase())) {
                return false;
            }

            // Style filter
            if (filters.style.length > 0 && !filters.style.includes(product.style.toLowerCase())) {
                return false;
            }

            // Discount filter
            if (filters.discount.length > 0) {
                const discount = ((product.price - product.discounted_price) / product.price) * 100;
                if (!filters.discount.some(minDiscount => discount >= parseInt(minDiscount))) {
                    return false;
                }
            }

            // Availability filter
            if (filters.availability.length > 0) {
                const availability = product.in_stock ? 'in_stock' : 'out_of_stock';
                if (!filters.availability.includes(availability)) {
                    return false;
                }
            }

            // Rating filter
            if (filters.rating.length > 0 && !filters.rating.some(minRating => product.rating >= parseFloat(minRating))) {
                return false;
            }

            return true;
        });

        applySorting();
        renderProducts();
        updateProductCount();
    }

    function applySorting() {
        const sortValue = sortBy.value;

        switch (sortValue) {
            case 'price_low':
                filteredProducts.sort((a, b) => a.discounted_price - b.discounted_price);
                break;
            case 'price_high':
                filteredProducts.sort((a, b) => b.discounted_price - a.discounted_price);
                break;
            case 'newest':
                // Assuming newer products have higher IDs
                filteredProducts.sort((a, b) => b.id - a.id);
                break;
            case 'rating':
                filteredProducts.sort((a, b) => b.rating - a.rating);
                break;
            case 'discount':
                filteredProducts.sort((a, b) => {
                    const discountA = ((a.price - a.discounted_price) / a.price) * 100;
                    const discountB = ((b.price - b.discounted_price) / b.price) * 100;
                    return discountB - discountA;
                });
                break;
            case 'featured':
            default:
                // Keep original order
                break;
        }

        renderProducts();
    }

    function renderProducts() {
        if (filteredProducts.length === 0) {
            productsContainer.classList.add('hidden');
            noResults.classList.remove('hidden');
            return;
        }

        productsContainer.classList.remove('hidden');
        noResults.classList.add('hidden');

        const isListView = currentView === 'list';
        productsContainer.className = isListView ? 'space-y-6' : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';

        productsContainer.innerHTML = filteredProducts.map(product => {
            const discount = product.discounted_price < product.price ?
                Math.round(((product.price - product.discounted_price) / product.price) * 100) : 0;

            if (isListView) {
                return `
                <div class="product-card bg-primary rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col md:flex-row">
                    <div class="md:w-1/3 relative">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-48 md:h-full object-cover">
                        ${discount > 0 ? `
                            <div class="absolute top-2 left-2 bg-red-600 text-secondary px-2 py-1 rounded text-sm font-semibold">
                                ${discount}% OFF
                            </div>
                        ` : ''}
                        ${!product.in_stock ? `
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="bg-gray-800 text-accent px-3 py-1 rounded text-sm">Out of Stock</span>
                            </div>
                        ` : ''}
                    </div>
                    <div class="p-6 md:w-2/3 flex flex-col justify-between">
                        <div>
                            <h3 class="text-secondary font-semibold text-lg mb-2">${product.name}</h3>
                            <p class="text-accent text-sm mb-2">${product.brand}</p>
                            <p class="text-accent text-sm mb-3">${product.material} • ${product.fit_type} Fit • ${product.sleeve_length} Sleeve</p>
                            <div class="flex items-center mb-3">
                                <div class="flex items-center">
                                    ${Array.from({ length: 5 }, (_, i) => `
                                        <svg class="w-4 h-4 ${i < Math.floor(product.rating) ? 'text-yellow-400' : 'text-gray-600'}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    `).join('')}
                                    <span class="text-accent text-sm ml-1">(${product.rating})</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-secondary font-bold text-lg">₹${product.discounted_price.toLocaleString()}</span>
                                ${product.discounted_price < product.price ? `
                                    <span class="text-accent text-sm line-through">₹${product.price.toLocaleString()}</span>
                                ` : ''}
                            </div>
                            <button class="bg-accent text-primary px-6 py-2 rounded hover:bg-gray-300 transition-colors duration-300 ${!product.in_stock ? 'opacity-50 cursor-not-allowed' : ''}" 
                                    ${!product.in_stock ? 'disabled' : ''}>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            `;
            } else {
                return `
                <div class="product-card bg-primary rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="relative">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-64 object-cover">
                        ${discount > 0 ? `
                            <div class="absolute top-2 left-2 bg-red-600 text-secondary px-2 py-1 rounded text-sm font-semibold">
                                ${discount}% OFF
                            </div>
                        ` : ''}
                        ${!product.in_stock ? `
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="bg-gray-800 text-accent px-3 py-1 rounded text-sm">Out of Stock</span>
                            </div>
                        ` : ''}
                        <button class="absolute top-2 right-2 bg-primary bg-opacity-70 text-secondary p-2 rounded-full hover:bg-opacity-100 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-secondary font-semibold mb-2 truncate">${product.name}</h3>
                        <p class="text-accent text-sm mb-2">${product.brand}</p>
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                ${Array.from({ length: 5 }, (_, i) => `
                                    <svg class="w-4 h-4 ${i < Math.floor(product.rating) ? 'text-yellow-400' : 'text-gray-600'}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                `).join('')}
                                <span class="text-accent text-sm ml-1">(${product.rating})</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="text-secondary font-bold text-lg">₹${product.discounted_price.toLocaleString()}</span>
                                ${product.discounted_price < product.price ? `
                                    <span class="text-accent text-sm line-through">₹${product.price.toLocaleString()}</span>
                                ` : ''}
                            </div>
                            <button class="bg-accent text-primary px-4 py-2 rounded hover:bg-gray-300 transition-colors duration-300 ${!product.in_stock ? 'opacity-50 cursor-not-allowed' : ''}" 
                                    ${!product.in_stock ? 'disabled' : ''}>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            `;
            }
        }).join('');
    }

    function updateProductCount() {
        productCount.textContent = filteredProducts.length;
    }

    function switchView(view) {
        currentView = view;

        if (view === 'grid') {
            gridView.classList.add('text-secondary');
            gridView.classList.remove('text-accent');
            listView.classList.add('text-accent');
            listView.classList.remove('text-secondary');
        } else {
            listView.classList.add('text-secondary');
            listView.classList.remove('text-accent');
            gridView.classList.add('text-accent');
            gridView.classList.remove('text-secondary');
        }

        renderProducts();
    }

    function clearAllFiltersHandler() {
        // Reset all checkboxes
        document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Reset price range
        const priceRange = document.getElementById('priceRange');
        if (priceRange) {
            priceRange.value = 10000;
        }

        const mobilePriceRange = document.getElementById('mobilePriceRange');
        if (mobilePriceRange) {
            mobilePriceRange.value = 10000;
        }

        // Reset filter state
        Object.keys(filters).forEach(key => {
            if (key === 'price') {
                filters[key] = { min: 0, max: 10000 };
            } else {
                filters[key] = [];
            }
        });

        applyFilters();
        closeMobileFiltersHandler();
    }

    function openMobileFilters() {
        mobileFilterSidebar.classList.remove('hidden');
        setTimeout(() => {
            mobileFilterSidebar.querySelector('.transform').classList.remove('-translate-x-full');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeMobileFiltersHandler() {
        mobileFilterSidebar.querySelector('.transform').classList.add('-translate-x-full');
        setTimeout(() => {
            mobileFilterSidebar.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
</script>

<style>
    /* Add this to your existing CSS */
    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Ensure smooth transitions for the SVG icons */
    .filter-toggle svg {
        transition: transform 0.3s ease-in-out;
    }

    /* Custom scrollbar for filter sections */
    .max-h-48::-webkit-scrollbar {
        width: 4px;
    }

    .max-h-48::-webkit-scrollbar-track {
        background: #374151;
    }

    .max-h-48::-webkit-scrollbar-thumb {
        background: #6B7280;
        border-radius: 2px;
    }

    .max-h-48::-webkit-scrollbar-thumb:hover {
        background: #9CA3AF;
    }

    /* Price range slider styling */
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        cursor: pointer;
    }

    input[type="range"]::-webkit-slider-track {
        background: #374151;
        height: 8px;
        border-radius: 4px;
    }

    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        background: #D1D5DB;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        cursor: pointer;
    }

    input[type="range"]::-moz-range-track {
        background: #374151;
        height: 8px;
        border-radius: 4px;
        border: none;
    }

    input[type="range"]::-moz-range-thumb {
        background: #D1D5DB;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        cursor: pointer;
        border: none;
    }

    /* Smooth transitions */
    .filter-content {
        transition: all 0.3s ease-in-out;
    }

    .product-card {
        transition: all 0.3s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-4px);
    }

    /* Color swatches with border */
    .color-swatch {
        border: 2px solid #4B5563;
        transition: all 0.3s ease-in-out;
    }

    .color-swatch.checked {
        border-color: #D1D5DB;
        box-shadow: 0 0 0 2px rgba(209, 213, 219, 0.5);
    }
</style>

<?php include BASE_PATH . 'includes/footer.php'; ?>