<?php
$pageTitle = "Checkout - Fashion Store";
require_once 'config/config.php';
include BASE_PATH . 'includes/header.php';
?>

<!-- Razorpay SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<main class="py-0">
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
                        <a href="cart.php" class="ml-2 text-secondary transition-colors duration-300">Cart</a>
                    </li>
                    <li class="flex items-center" aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="ml-2 text-secondary">Checkout</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold mb-8 text-center">Secure Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Forms -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Customer Information -->
                <div class="bg-primary p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Contact Information
                    </h2>
                    <form id="checkoutForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">First Name *</label>
                                <input type="text" name="firstName" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Last Name *</label>
                                <input type="text" name="lastName" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-secondary mb-2">Email *</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary">
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-secondary mb-2">Phone Number *</label>
                            <input type="tel" name="phone" required pattern="[0-9]{10}"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary"
                                placeholder="10-digit mobile number">
                        </div>
                    </form>
                </div>

                <!-- Shipping Address -->
                <div class="bg-primary p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Shipping Address
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Address Line 1 *</label>
                            <input type="text" name="address1" required
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary"
                                placeholder="House No., Building Name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Address Line 2</label>
                            <input type="text" name="address2"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary"
                                placeholder="Area, Street, Sector, Village">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">City *</label>
                                <input type="text" name="city" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">State *</label>
                                <select name="state" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary">
                                    <option value="">Select State</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">PIN Code *</label>
                                <input type="text" name="pincode" required pattern="[0-9]{6}" maxlength="6"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary"
                                    placeholder="6-digit PIN code">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Landmark</label>
                                <input type="text" name="landmark"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Method (Delhivery) -->
                <div class="bg-primary p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                        Shipping Method
                    </h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-secondary transition-colors">
                            <input type="radio" name="shipping" value="standard" checked class="mr-4 w-5 h-5">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-secondary">Standard Delivery</p>
                                        <p class="text-sm text-gray-400">Delivered by Delhivery • 5-7 business days</p>
                                    </div>
                                    <span class="font-semibold text-secondary">₹99</span>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-secondary transition-colors">
                            <input type="radio" name="shipping" value="express" class="mr-4 w-5 h-5">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-secondary">Express Delivery</p>
                                        <p class="text-sm text-gray-400">Delivered by Delhivery • 2-3 business days</p>
                                    </div>
                                    <span class="font-semibold text-secondary">₹199</span>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-secondary transition-colors">
                            <input type="radio" name="shipping" value="overnight" class="mr-4 w-5 h-5">
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold text-secondary">Same Day Delivery</p>
                                        <p class="text-sm text-gray-400">Delivered by Delhivery • Within 24 hours</p>
                                        <p class="text-xs text-green-500 mt-1">Available in select cities</p>
                                    </div>
                                    <span class="font-semibold text-secondary">₹299</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-primary p-6 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Payment Method
                    </h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-secondary transition-colors">
                            <input type="radio" name="payment" value="razorpay" checked class="mr-4 w-5 h-5">
                            <div class="flex-1">
                                <p class="font-semibold text-secondary">Pay with Razorpay</p>
                                <p class="text-sm text-gray-400">Credit/Debit Card, UPI, Net Banking, Wallet</p>
                            </div>
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 60'%3E%3Cpath fill='%230c2f54' d='M0 0h200v60H0z'/%3E%3Ctext x='50%25' y='50%25' fill='white' font-size='24' font-family='Arial' text-anchor='middle' dy='.3em'%3ERazorpay%3C/text%3E%3C/svg%3E" alt="Razorpay" class="h-8">
                        </label>
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-secondary transition-colors">
                            <input type="radio" name="payment" value="cod" class="mr-4 w-5 h-5">
                            <div class="flex-1">
                                <p class="font-semibold text-secondary">Cash on Delivery</p>
                                <p class="text-sm text-gray-400">Pay when you receive your order</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-primary p-6 rounded-lg shadow-lg sticky top-6">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                        <!-- Sample Item 1 -->
                        <div class="flex items-center space-x-4 pb-4 border-b border-gray-700">
                            <img src="https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274" 
                                 alt="Product" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-secondary">Luxury Shirt</h4>
                                <p class="text-xs text-gray-400">Size: M • Qty: 1</p>
                                <p class="text-sm font-semibold text-secondary mt-1">₹2,239</p>
                            </div>
                        </div>
                        <!-- Sample Item 2 -->
                        <div class="flex items-center space-x-4 pb-4 border-b border-gray-700">
                            <img src="https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165" 
                                 alt="Product" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-secondary">Formal Shirt</h4>
                                <p class="text-xs text-gray-400">Size: L • Qty: 2</p>
                                <p class="text-sm font-semibold text-secondary mt-1">₹4,478</p>
                            </div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-secondary">
                            <span>Subtotal</span>
                            <span id="subtotal">₹6,717</span>
                        </div>
                        <div class="flex justify-between text-secondary">
                            <span>Shipping</span>
                            <span id="shippingCost">₹99</span>
                        </div>
                        <div class="flex justify-between text-green-500">
                            <span>Discount</span>
                            <span id="discount">- ₹500</span>
                        </div>
                        <div class="border-t border-gray-700 pt-3">
                            <div class="flex justify-between text-secondary text-xl font-bold">
                                <span>Total</span>
                                <span id="totalAmount">₹6,316</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-secondary mb-2">Promo Code</label>
                        <div class="flex space-x-2">
                            <input type="text" id="promoCode" 
                                class="flex-1 px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:border-secondary text-secondary"
                                placeholder="Enter code">
                            <button type="button" id="applyPromo"
                                class="px-6 py-2 bg-secondary text-primary font-semibold rounded-lg hover:bg-opacity-90 transition-colors">
                                Apply
                            </button>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="button" id="placeOrderBtn"
                        class="w-full bg-secondary text-primary font-bold py-4 rounded-lg hover:bg-opacity-90 transition-colors flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Place Secure Order
                    </button>

                    <!-- Security Badges -->
                    <div class="mt-6 flex items-center justify-center space-x-4 text-xs text-gray-400">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Secure Payment
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            SSL Encrypted
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Shipping cost calculation
const shippingOptions = {
    standard: 99,
    express: 199,
    overnight: 299
};

document.querySelectorAll('input[name="shipping"]').forEach(radio => {
    radio.addEventListener('change', function() {
        updateTotal();
    });
});

function updateTotal() {
    const selectedShipping = document.querySelector('input[name="shipping"]:checked').value;
    const shippingCost = shippingOptions[selectedShipping];
    const subtotal = 6717;
    const discount = 500;
    const total = subtotal + shippingCost - discount;
    
    document.getElementById('shippingCost').textContent = '₹' + shippingCost;
    document.getElementById('totalAmount').textContent = '₹' + total.toLocaleString('en-IN');
}

// Promo code application
document.getElementById('applyPromo').addEventListener('click', function() {
    const promoInput = document.getElementById('promoCode');
    const code = promoInput.value.trim().toUpperCase();
    
    // Sample promo codes
    const promoCodes = {
        'SAVE500': 500,
        'FASHION20': 1343, // 20% of 6717
        'FIRST100': 100
    };
    
    if (promoCodes[code]) {
        document.getElementById('discount').textContent = '- ₹' + promoCodes[code];
        updateTotal();
        alert('Promo code applied successfully!');
        promoInput.value = '';
    } else if (code) {
        alert('Invalid promo code');
    }
});

// Razorpay Integration
document.getElementById('placeOrderBtn').addEventListener('click', function() {
    const form = document.getElementById('checkoutForm');
    
    // Validate form
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
    
    if (paymentMethod === 'cod') {
        // Handle Cash on Delivery
        if (confirm('Confirm Cash on Delivery order?')) {
            // Submit order to backend
            processCODOrder();
        }
    } else {
        // Handle Razorpay payment
        initiateRazorpayPayment();
    }
});

function initiateRazorpayPayment() {
    const totalAmount = parseInt(document.getElementById('totalAmount').textContent.replace(/[^0-9]/g, ''));
    
    const options = {
        "key": "YOUR_RAZORPAY_KEY_ID", // Replace with your Razorpay key
        "amount": totalAmount * 100, // Amount in paise
        "currency": "INR",
        "name": "Fashion Store",
        "description": "Purchase from Fashion Store",
        "image": "https://your-logo-url.com/logo.png",
        "order_id": "", // Generate from backend
        "handler": function (response){
            // Payment successful
            console.log('Payment ID: ' + response.razorpay_payment_id);
            console.log('Order ID: ' + response.razorpay_order_id);
            console.log('Signature: ' + response.razorpay_signature);
            
            // Verify payment on backend and create order
            verifyPaymentAndCreateOrder(response);
        },
        "prefill": {
            "name": document.querySelector('input[name="firstName"]').value + ' ' + document.querySelector('input[name="lastName"]').value,
            "email": document.querySelector('input[name="email"]').value,
            "contact": document.querySelector('input[name="phone"]').value
        },
        "notes": {
            "address": document.querySelector('input[name="address1"]').value
        },
        "theme": {
            "color": "#000000"
        },
        "modal": {
            "ondismiss": function(){
                alert('Payment cancelled');
            }
        }
    };
    
    const rzp = new Razorpay(options);
    rzp.open();
}

function verifyPaymentAndCreateOrder(paymentResponse) {
    // Send payment details to backend for verification
    fetch('process-payment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            payment_id: paymentResponse.razorpay_payment_id,
            order_id: paymentResponse.razorpay_order_id,
            signature: paymentResponse.razorpay_signature,
            // Add shipping and customer details
            customer: {
                firstName: document.querySelector('input[name="firstName"]').value,
                lastName: document.querySelector('input[name="lastName"]').value,
                email: document.querySelector('input[name="email"]').value,
                phone: document.querySelector('input[name="phone"]').value
            },
            shipping: {
                address1: document.querySelector('input[name="address1"]').value,
                address2: document.querySelector('input[name="address2"]').value,
                city: document.querySelector('input[name="city"]').value,
                state: document.querySelector('input[name="state"]').value,
                pincode: document.querySelector('input[name="pincode"]').value,
                landmark: document.querySelector('input[name="landmark"]').value
            },
            shippingMethod: document.querySelector('input[name="shipping"]:checked').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to success page
            window.location.href = 'order-success.php?order_id=' + data.order_id;
        } else {
            alert('Payment verification failed. Please contact support.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

function processCODOrder() {
    // Process Cash on Delivery order
    fetch('process-cod.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            customer: {
                firstName: document.querySelector('input[name="firstName"]').value,
                lastName: document.querySelector('input[name="lastName"]').value,
                email: document.querySelector('input[name="email"]').value,
                phone: document.querySelector('input[name="phone"]').value
            },
            shipping: {
                address1: document.querySelector('input[name="address1"]').value,
                address2: document.querySelector('input[name="address2"]').value,
                city: document.querySelector('input[name="city"]').value,
                state: document.querySelector('input[name="state"]').value,
                pincode: document.querySelector('input[name="pincode"]').value,
                landmark: document.querySelector('input[name="landmark"]').value
            },
            shippingMethod: document.querySelector('input[name="shipping"]:checked').value,
            paymentMethod: 'cod'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'order-success.php?order_id=' + data.order_id;
        } else {
            alert('Order failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}

// Initialize total on page load
updateTotal();
</script>

<?php include BASE_PATH . 'includes/footer.php'; ?>