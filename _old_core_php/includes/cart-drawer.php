<?php
require_once __DIR__ . '/../config/config.php';
$pageTitle = "Shopping Cart - Fashion Store";

$cartItems = [
    [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ], [
        'id' => 1,
        'name' => 'Celestial Veil Oversized T-Shirt',
        'color' => 'Black',
        'size' => 'M',
        'price' => 2499,
        'discounted_price' => 2009,
        'quantity' => 1,
        'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'
    ],
];
$subtotal = 2009;
$shipping = 0;
$total = $subtotal + $shipping;
?>

<!-- Cart Modal -->
<div class="fixed inset-0 z-50 hidden" id="cartModal">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50" id="cartBackdrop"></div>

    <!-- Drawer -->
    <div
        class="absolute right-0 top-0 h-full w-full max-w-md bg-primary shadow-xl transform transition-transform duration-300 translate-x-full flex flex-col">

        <!-- HEADER (Fixed Top) -->
        <div class="border-b border-gray-700 p-4 flex-shrink-0 bg-primary sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-secondary">Shopping Cart (<?php echo count($cartItems); ?>)</h2>
                <button id="closeCart" class="text-secondary hover:text-accent transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="mt-2 bg-red-600 text-secondary text-sm py-1 px-3 rounded-full inline-block">
                Sale ends in: <span class="font-bold">02h 30m 47s</span>
            </div>
        </div>

        <!-- SCROLLABLE CART CONTENT -->
        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="flex gap-4 pb-6 border-b border-gray-700">
                        <div class="flex-shrink-0 w-20 h-24 bg-gray-800 rounded-lg overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h3 class="text-secondary font-semibold text-sm mb-1"><?php echo $item['name']; ?></h3>
                            <p class="text-accent text-xs mb-2">Color: <?php echo $item['color']; ?> | Size:
                                <?php echo $item['size']; ?></p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <button
                                        class="w-6 h-6 rounded border border-accent text-accent flex items-center justify-center hover:bg-accent hover:text-primary transition"
                                        data-action="decrease" data-item="<?php echo $item['id']; ?>">-</button>
                                    <span
                                        class="text-secondary text-sm font-medium w-6 text-center quantity-display-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
                                    <button
                                        class="w-6 h-6 rounded border border-accent text-accent flex items-center justify-center hover:bg-accent hover:text-primary transition"
                                        data-action="increase" data-item="<?php echo $item['id']; ?>">+</button>
                                </div>
                                <div class="text-right">
                                    <p class="text-secondary font-bold">₹<?php echo number_format($item['discounted_price']); ?>
                                    </p>
                                    <p class="text-accent text-sm line-through">₹<?php echo number_format($item['price']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-secondary text-center py-8">Your cart is empty.</p>
            <?php endif; ?>

            <!-- Offers Section -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-secondary font-semibold">2 offers available</h4>
                    <button class="text-accent text-sm underline hover:text-secondary transition">View all
                        coupons</button>
                </div>
            </div>
        </div>

        <!-- ORDER SUMMARY (Fixed Bottom) -->
        <div class="border-t border-gray-700 p-4 bg-gray-900 flex-shrink-0 sticky bottom-0 z-10">
            <h4 class="text-secondary font-semibold mb-3">Order Summary</h4>

            <!--<div class="space-y-2 text-sm mb-4">-->
            <!--    <div class="flex justify-between">-->
            <!--        <span class="text-accent">Total MRP</span>-->
            <!--        <span class="text-secondary">₹<?php echo number_format($subtotal); ?></span>-->
            <!--    </div>-->
            <!--    <div class="flex justify-between">-->
            <!--        <span class="text-accent">Bag Discount</span>-->
            <!--        <span-->
            <!--            class="text-green-500">-₹<?php echo number_format($cartItems[0]['price'] - $cartItems[0]['discounted_price']); ?></span>-->
            <!--    </div>-->
            <!--    <div class="flex justify-between">-->
            <!--        <span class="text-accent">Shipping</span>-->
            <!--        <span class="text-green-500">FREE</span>-->
            <!--    </div>-->
            <!--</div>-->

            <div class="flex justify-between items-center mb-4 py-2 border-t border-gray-700">
                <span class="text-secondary font-bold text-lg">Total Payable</span>
                <span class="text-secondary font-bold text-lg">₹<?php echo number_format($total); ?></span>
            </div>

            <!--<div class="grid grid-cols-3 gap-2 mb-4">-->
            <!--    <div class="text-center p-2 bg-gray-800 rounded">-->
            <!--        <div class="text-green-500 text-xs font-semibold">CASH ON DELIVERY</div>-->
            <!--    </div>-->
            <!--    <div class="text-center p-2 bg-gray-800 rounded">-->
            <!--        <div class="text-green-500 text-xs font-semibold">FREE SHIPPING</div>-->
            <!--    </div>-->
            <!--    <div class="text-center p-2 bg-gray-800 rounded">-->
            <!--        <div class="text-green-500 text-xs font-semibold">EASY RETURNS</div>-->
            <!--    </div>-->
            <!--</div>-->

            <a href="<?php echo BASE_URL; ?>checkout.php"><button
                    class="w-full bg-accent text-primary py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition mb-3">
                    PROCEED TO BUY
                </button></a>

            <!--<div class="text-center">-->
            <!--    <p class="text-accent text-xs mb-2">100% secure transaction</p>-->
            <!--    <div class="flex justify-center space-x-2 text-xs text-accent">-->
            <!--        <span>PAY</span><span>VISA</span><span>RUPAY</span><span>MASTERCARD</span><span>pay</span>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </div>
</div>

<script>
    // Cart Modal Logic
    function openCart() {
        const modal = document.getElementById('cartModal');
        const drawer = modal.querySelector('.transform');
        modal.classList.remove('hidden');
        setTimeout(() => drawer.classList.remove('translate-x-full'), 10);
        document.body.style.overflow = 'hidden';
    }

    function closeCart() {
        const modal = document.getElementById('cartModal');
        const drawer = modal.querySelector('.transform');
        drawer.classList.add('translate-x-full');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('cartBackdrop').addEventListener('click', closeCart);
        document.getElementById('closeCart').addEventListener('click', closeCart);
        document.addEventListener('keydown', e => e.key === 'Escape' && closeCart());


    });
    // Make openCart function globally available
    window.openCart = openCart;
</script>
    
<style>
    /* Smooth transitions */
    .transform {
        transition: transform 0.3s ease-in-out;
    }

    /* Custom scrollbar for cart */
    .h-\[calc\(100vh-200px\)\]::-webkit-scrollbar {
        width: 4px;
    }

    .h-\[calc\(100vh-200px\)\]::-webkit-scrollbar-track {
        background: #374151;
    }

    .h-\[calc\(100vh-200px\)\]::-webkit-scrollbar-thumb {
        background: #6B7280;
        border-radius: 2px;
    }

    .h-\[calc\(100vh-200px\)\]::-webkit-scrollbar-thumb:hover {
        background: #9CA3AF;
    }
</style>