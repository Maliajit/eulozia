@extends('customer.layouts.master')

@section('title', 'Secure Checkout - Fashion Store')

@push('scripts')
    <!-- Razorpay SDK -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush

@section('content')
<main class="py-0">
    <!-- Breadcrumb Section -->
    <section class="bg-primary">
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
                        <a href="{{ route('customer.cart.index') }}" class="ml-2 text-secondary transition-colors duration-300">Cart</a>
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
        <h1 class="text-4xl font-bold mb-8 text-center text-secondary">Secure Checkout</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Forms -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Customer Information -->
                <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Contact Information
                    </h2>
                    <form id="checkoutForm">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">First Name *</label>
                                <input type="text" name="firstName" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Last Name *</label>
                                <input type="text" name="lastName" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-secondary mb-2">Email *</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary">
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-secondary mb-2">Phone Number *</label>
                            <input type="tel" name="phone" required pattern="[0-9]{10}"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary"
                                placeholder="10-digit mobile number">
                        </div>
                    </form>
                </div>

                <!-- Shipping Address -->
                <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800">
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
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary"
                                placeholder="House No., Building Name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-secondary mb-2">Address Line 2</label>
                            <input type="text" name="address2"
                                class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary"
                                placeholder="Area, Street, Sector, Village">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">City *</label>
                                <input type="text" name="city" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">State *</label>
                                <select name="state" required
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary appearance-none">
                                    <option value="">Select State</option>
                                    @foreach(['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'] as $state)
                                        <option value="{{ $state }}">{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">PIN Code *</label>
                                <input type="text" name="pincode" required pattern="[0-9]{6}" maxlength="6"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary"
                                    placeholder="6-digit PIN code">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-secondary mb-2">Landmark</label>
                                <input type="text" name="landmark"
                                    class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Method (Delhivery) -->
                <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                        </svg>
                        Shipping Method
                    </h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-accent transition-colors">
                            <input type="radio" name="shipping" value="standard" checked class="mr-4 w-5 h-5 accent-accent">
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
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-accent transition-colors">
                            <input type="radio" name="shipping" value="express" class="mr-4 w-5 h-5 accent-accent">
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
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-accent transition-colors">
                            <input type="radio" name="shipping" value="overnight" class="mr-4 w-5 h-5 accent-accent">
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
                <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Payment Method
                    </h2>
                    <div class="space-y-3">
                        @if(isset($paymentMethods['online']) && $paymentMethods['online']['available'])
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-accent transition-colors">
                            <input type="radio" name="payment_method" value="online" checked class="mr-4 w-5 h-5 accent-accent">
                            <div class="flex-1">
                                <p class="font-semibold text-secondary">Pay Online (Razorpay)</p>
                                <p class="text-sm text-gray-400">Credit/Debit Card, UPI, Net Banking, Wallet</p>
                            </div>
                            <div class="bg-white p-1 rounded">
                                <img src="https://razorpay.com/assets/razorpay-glyph.svg" alt="Razorpay" class="h-6">
                            </div>
                        </label>
                        @endif

                        @if(isset($paymentMethods['cod']) && $paymentMethods['cod']['available'])
                        <label class="flex items-center p-4 bg-gray-900 rounded-lg cursor-pointer border border-gray-700 hover:border-accent transition-colors">
                            <input type="radio" name="payment_method" value="cod" {{ !(isset($paymentMethods['online']) && $paymentMethods['online']['available']) ? 'checked' : '' }} class="mr-4 w-5 h-5 accent-accent">
                            <div class="flex-1">
                                <p class="font-semibold text-secondary">Cash on Delivery</p>
                                <p class="text-sm text-gray-400">Pay when you receive your order</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </label>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800 sticky top-6">
                    <h2 class="text-2xl font-semibold mb-6 text-secondary">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                        @foreach($cart['items'] ?? [] as $item)
                        <div class="flex items-center space-x-4 pb-4 border-b border-gray-800">
                            <img src="{{ $item['image'] }}" 
                                 alt="{{ $item['product_name'] }}" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-secondary">{{ $item['product_name'] }}</h4>
                                <p class="text-xs text-gray-400">Qty: {{ $item['quantity'] }}</p>
                                <p class="text-sm font-semibold text-secondary mt-1">₹{{ number_format($item['total']) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-secondary">
                            <span>Subtotal</span>
                            <span id="summary-subtotal">₹{{ number_format($cart['subtotal']) }}</span>
                        </div>
                        <div class="flex justify-between text-secondary">
                            <span>Shipping</span>
                            <span id="summary-shipping">₹0</span>
                        </div>
                        <div class="flex justify-between text-green-500">
                            <span>Discount</span>
                            <span id="summary-discount">- ₹{{ number_format($cart['discount_total'] ?? 0) }}</span>
                        </div>
                        <div class="flex justify-between text-secondary">
                            <span>Tax</span>
                            <span id="summary-tax">₹{{ number_format($cart['tax_total'] ?? 0) }}</span>
                        </div>
                        <div class="border-t border-gray-800 pt-3">
                            <div class="flex justify-between text-secondary text-xl font-bold">
                                <span>Total</span>
                                <span id="summary-total">₹{{ number_format($cart['grand_total']) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-secondary mb-2">Promo Code</label>
                        <div class="flex space-x-2">
                            <input type="text" id="promoCode" 
                                class="flex-1 px-4 py-2 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary"
                                placeholder="Enter code">
                            <button type="button" id="applyPromo"
                                class="px-6 py-2 bg-accent text-primary font-bold rounded-lg hover:bg-opacity-90 transition-colors">
                                Apply
                            </button>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="button" id="placeOrderBtn"
                        class="w-full bg-accent text-primary font-bold py-4 rounded-lg hover:bg-opacity-90 transition-colors flex items-center justify-center uppercase tracking-wider">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtotal = {{ $cart['subtotal'] }};
        const tax = {{ $cart['tax_total'] ?? 0 }};
        const discount = {{ $cart['discount_total'] ?? 0 }};
        let shippingCost = 0;

        const pincodeInput = document.querySelector('input[name="pincode"]');
        const form = document.getElementById('checkoutForm');
        
        // Restore form data from sessionStorage
        restoreFormData();

        // Save form data on input
        form.addEventListener('input', saveFormData);

        // Handle Pincode Change for Shipping
        pincodeInput.addEventListener('change', function() {
            const pincode = this.value;
            if (pincode.length === 6) {
                checkShipping(pincode);
            }
        });

        if (pincodeInput.value.length === 6) {
            checkShipping(pincodeInput.value);
        }

        function saveFormData() {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            delete data._token; // Don't save CSRF
            sessionStorage.setItem('checkout_form_data', JSON.stringify(data));
        }

        function restoreFormData() {
            const savedData = sessionStorage.getItem('checkout_form_data');
            if (savedData) {
                const data = JSON.parse(savedData);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input && input.type !== 'radio') {
                        input.value = data[key];
                    } else if (input && input.type === 'radio') {
                        const radio = form.querySelector(`input[name="${key}"][value="${data[key]}"]`);
                        if (radio) radio.checked = true;
                    }
                });
            }
        }

        function checkShipping(pincode) {
            fetch('{{ route("customer.checkout.shipping.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pincode: pincode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.available_couriers.length > 0) {
                    shippingCost = data.available_couriers[0].rate;
                    document.getElementById('summary-shipping').textContent = '₹' + shippingCost;
                    updateTotal();
                    
                    // Auto-fill city/state if available
                    if (data.city) document.querySelector('input[name="city"]').value = data.city;
                    if (data.state) document.querySelector('select[name="state"]').value = data.state;
                    
                    saveFormData(); // Save auto-filled data
                }
            });
        }

        function updateTotal() {
            const total = subtotal + tax + shippingCost - discount;
            document.getElementById('summary-total').textContent = '₹' + total.toLocaleString('en-IN');
        }

        // Place Order Button
        document.getElementById('placeOrderBtn').addEventListener('click', function() {
            // Validate form
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            const paymentMethodInput = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethodInput) {
                alert('Please select a payment method.');
                return;
            }
            const paymentMethod = paymentMethodInput.value;
            
            if (paymentMethod === 'cod') {
                processCheckout('cod');
            } else {
                initiateOnlinePayment();
            }
        });

        function handleAuthError() {
            // Redirect to login with intended URL
            window.location.href = '{{ route("customer.login") }}?redirect={{ route("customer.checkout.index") }}';
        }

        function processCheckout(method) {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            data.payment_method = method;
            data.terms_agree = 1;

            fetch('{{ route("customer.checkout.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (response.status === 401) {
                    handleAuthError();
                    return;
                }
                if (response.redirected) {
                    sessionStorage.removeItem('checkout_form_data'); // Clear on success
                    window.location.href = response.url;
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data && data.success) {
                    sessionStorage.removeItem('checkout_form_data');
                    window.location.href = '{{ route("customer.checkout.index") }}/confirmation/' + data.order.id;
                } else if (data && data.message) {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function initiateOnlinePayment() {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            data.payment_method = 'online';

            fetch('{{ route("customer.checkout.razorpay.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (response.status === 401) {
                    handleAuthError();
                    return;
                }
                return response.json();
            })
            .then(res => {
                if (!res) return;
                if (res.success) {
                    const options = {
                        "key": res.key_id,
                        "amount": res.amount,
                        "currency": res.currency,
                        "name": "Eulozia",
                        "description": "Purchase Payment",
                        "order_id": res.order_id,
                        "handler": function (response){
                            submitPaymentResponse(response);
                        },
                        "prefill": {
                            "name": data.full_name,
                            "email": data.email,
                            "contact": data.phone
                        },
                        "theme": { "color": "#E5E7EB" }
                    };
                    const rzp = new Razorpay(options);
                    rzp.open();
                } else {
                    alert(res.message || 'Failed to initiate payment');
                }
            });
        }

        function submitPaymentResponse(paymentResponse) {
            fetch('{{ route("customer.checkout.payment.callback") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(paymentResponse)
            })
            .then(response => {
                if (response.status === 401) {
                    handleAuthError();
                    return;
                }
                if (response.redirected) {
                    sessionStorage.removeItem('checkout_form_data');
                    window.location.href = response.url;
                }
            });
        }
    });
</script>
@endpush
@endsection
