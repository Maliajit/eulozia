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
                
                    <form id="checkoutForm">
                        @csrf
                        <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800 mb-6">
                            <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Contact Information
                            </h2>
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
                                    placeholder="10-digit mobile number"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);"
                                    inputmode="numeric"
                                    maxlength="10"
                                    minlength="10">
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800 mb-6">
                            <h2 class="text-2xl font-semibold mb-6 text-secondary flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Shipping Address
                            </h2>

                            @if(isset($addresses) && $addresses->count() > 0)
                            <!-- Saved Addresses Selection -->
                            <div class="mb-8 overflow-x-auto">
                                <p class="text-sm font-medium text-gray-400 mb-4">Select from your saved addresses:</p>
                                <div class="flex space-x-4 pb-4 min-w-max">
                                    @foreach($addresses as $address)
                                    <div class="address-card cursor-pointer p-4 bg-gray-900 border-2 {{ $address->is_default ? 'border-accent' : 'border-gray-700' }} rounded-lg hover:border-accent transition-all w-64 group relative"
                                        data-address='@json($address)'>
                                        @if($address->is_default)
                                            <span class="absolute top-2 right-2 bg-accent text-primary text-[10px] font-bold px-1.5 py-0.5 rounded uppercase">Default</span>
                                        @endif
                                        <div class="flex items-start mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            <h3 class="font-bold text-secondary truncate">{{ $address->name }}</h3>
                                        </div>
                                        <p class="text-xs text-gray-400 line-clamp-2 mb-1">{{ $address->address }}</p>
                                        <p class="text-xs text-gray-400">{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                                        <p class="text-xs text-gray-400 mt-2">{{ $address->mobile }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="relative flex py-4 items-center">
                                <div class="flex-grow border-t border-gray-800"></div>
                                <span class="flex-shrink mx-4 text-gray-500 text-xs uppercase tracking-widest">Or enter new address</span>
                                <div class="flex-grow border-t border-gray-800"></div>
                            </div>
                            @endif

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
                                            placeholder="6-digit PIN code"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);"
                                            inputmode="numeric"
                                            maxlength="6"
                                            minlength="6">
                                        <div id="pincode-status" class="mt-2 text-sm hidden"></div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-secondary mb-2">Landmark</label>
                                        <input type="text" name="landmark"
                                            class="w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-primary p-6 rounded-lg shadow-lg border border-gray-800 mb-6">
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
                                <input type="hidden" name="terms_agree" value="1">
                            </div>
                        </div>
                    </form>

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
                            <span id="summary-subtotal">₹{{ number_format(round($cart['subtotal'])) }}</span>
                        </div>
                        @if($cart['discount_total'] > 0)
                        <div class="flex justify-between text-green-500 font-medium">
                            <span>Discount @if(isset($cart['offer']) && $cart['offer']['type'] == 'percentage') ({{ round($cart['offer']['discount_value']) }}%) @endif</span>
                            <span id="summary-discount">- ₹{{ number_format(round($cart['discount_total'])) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-secondary">
                            <span>Tax</span>
                            <span id="summary-tax">₹{{ number_format(round($cart['tax_total'] ?? 0)) }}</span>
                        </div>
                        <div class="flex justify-between text-secondary">
                            <span>Shipping</span>
                            <span id="summary-shipping">₹{{ number_format(round($cart['shipping_total'] ?? 0)) }}</span>
                        </div>
                        <div class="border-t border-gray-800 pt-3">
                            <div class="flex justify-between text-secondary text-2xl font-bold">
                                <span>Total</span>
                                <span id="summary-total">₹{{ number_format(round($cart['grand_total'])) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Code Section -->
                    <div class="mb-6 border-t border-gray-800 pt-6">
                        @if(isset($cart['offer']))
                            <!-- Applied Promo State -->
                            <div class="flex items-center justify-between p-4 bg-green-500 bg-opacity-10 border border-green-500 border-opacity-20 rounded-xl">
                                <div class="flex items-center">
                                    <div class="bg-green-500 p-1.5 rounded-full mr-3">
                                        <svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-green-500 font-bold uppercase tracking-widest mb-0.5">Promo Applied</p>
                                        <p class="text-sm text-secondary font-bold">{{ $cart['offer']['code'] }}</p>
                                    </div>
                                </div>
                                <button type="button" id="removePromo" class="text-xs text-rose-500 hover:text-rose-400 font-bold uppercase tracking-widest transition-colors flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Remove
                                </button>
                            </div>
                        @else
                            <!-- Collapsible Promo Input -->
                            <button type="button" id="togglePromoBtn" class="flex items-center justify-between w-full text-secondary font-bold py-2 group focus:outline-none">
                                <span class="group-hover:text-accent transition-colors flex items-center">
                                    Apply Promo Code
                                    <span class="ml-2 inline-block transition-transform duration-300" id="promoChevron">▼</span>
                                </span>
                            </button>
                            
                            <div id="promoContent" class="hidden mt-4 space-y-5 animate-fadeIn">
                                <div class="flex space-x-2">
                                    <input type="text" id="promoCode" 
                                        class="flex-1 px-4 py-2.5 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-1 focus:ring-accent text-secondary text-sm"
                                        placeholder="Enter promo code">
                                    <button type="button" id="applyPromo"
                                        class="px-6 py-2.5 bg-accent text-primary font-bold rounded-lg hover:bg-opacity-90 transition-colors uppercase text-sm tracking-wider">
                                        Apply
                                    </button>
                                </div>

                                @if(isset($availableOffers) && $availableOffers->count() > 0)
                                    <div>
                                        <div class="flex items-center mb-4">
                                            <div class="h-px bg-gray-800 flex-1"></div>
                                            <span class="px-3 text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">Available Offers</span>
                                            <div class="h-px bg-gray-800 flex-1"></div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-2.5">
                                            @foreach($availableOffers as $offer)
                                                <div class="offer-card group cursor-pointer p-4 bg-gray-900 border border-gray-800 rounded-xl hover:border-accent hover:bg-gray-800/50 transition-all flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-1">
                                                            <span class="text-accent font-black text-sm tracking-wider">{{ $offer->code }}</span>
                                                            <span class="ml-3 text-[10px] font-bold text-secondary bg-gray-800 px-2 py-0.5 rounded">
                                                                @if($offer->offer_type === 'percentage')
                                                                    {{ $offer->discount_value }}% OFF
                                                                @elseif($offer->offer_type === 'fixed')
                                                                    ₹{{ $offer->discount_value }} OFF
                                                                @elseif($offer->offer_type === 'free_shipping')
                                                                    FREE SHIP
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <p class="text-xs text-gray-400 font-medium">{{ $offer->name }}</p>
                                                    </div>
                                                    <button type="button" onclick="selectPromoCode('{{ $offer->code }}')" 
                                                        class="ml-4 px-4 py-1.5 text-[10px] font-black text-accent border border-accent rounded-full hover:bg-accent hover:text-primary transition-all uppercase tracking-widest">
                                                        Apply
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
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
        pincodeInput.addEventListener('input', function() {
            const pincode = this.value.replace(/[^0-9]/g, '');
            this.value = pincode; // Sanitize input
            if (pincode.length === 6) {
                checkShipping(pincode);
            }
        });

        // Handle Saved Address Selection
        const addressCards = document.querySelectorAll('.address-card');
        addressCards.forEach(card => {
            card.addEventListener('click', function() {
                const addressData = JSON.parse(this.dataset.address);
                
                // Update UI selection state
                addressCards.forEach(c => c.classList.remove('border-accent'));
                addressCards.forEach(c => c.classList.add('border-gray-700'));
                this.classList.remove('border-gray-700');
                this.classList.add('border-accent');

                // Split name (simple split for first/last)
                const names = addressData.name.split(' ');
                form.querySelector('[name="firstName"]').value = names[0] || '';
                form.querySelector('[name="lastName"]').value = names.slice(1).join(' ') || '';
                
                // Fill other fields
                form.querySelector('[name="email"]').value = '{{ Auth::guard("customer")->user()->email ?? "" }}';
                form.querySelector('[name="phone"]').value = addressData.mobile || '';
                form.querySelector('[name="address1"]').value = addressData.address || '';
                form.querySelector('[name="city"]').value = addressData.city || '';
                form.querySelector('[name="pincode"]').value = addressData.pincode || '';
                
                const stateSelect = form.querySelector('[name="state"]');
                if (stateSelect) {
                    const option = Array.from(stateSelect.options).find(opt => opt.value.toLowerCase() === addressData.state.toLowerCase());
                    if (option) stateSelect.value = option.value;
                }

                // Trigger shipping check
                if (addressData.pincode && addressData.pincode.length === 6) {
                    checkShipping(addressData.pincode);
                }
                
                saveFormData();
            });
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
            const statusDiv = document.getElementById('pincode-status');
            statusDiv.textContent = 'Checking availability...';
            statusDiv.classList.remove('hidden', 'text-green-500', 'text-red-500');
            statusDiv.classList.add('text-gray-400');

            fetch('{{ route("customer.checkout.shipping.check") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pincode: pincode })
            })
            .then(async response => {
                const contentType = response.headers.get("content-type");
                if (!response.ok) {
                    if (response.status === 429) {
                        throw new Error('Too many requests. Please wait a moment and try again.');
                    }
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Error checking pincode serviceability');
                    }
                    throw new Error('Server error occurred. Please try again later.');
                }
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                }
                throw new Error('Invalid response from server');
            })
            .then(data => {
                if (data.success && data.available_couriers && data.available_couriers.length > 0) {
                    shippingCost = Math.round(data.available_couriers[0].rate);
                    document.getElementById('summary-shipping').textContent = '₹' + shippingCost;
                    updateTotal();
                    
                    statusDiv.textContent = '✓ Delivery available to this pincode';
                    statusDiv.classList.remove('text-gray-400', 'text-red-500', 'hidden');
                    statusDiv.classList.add('text-green-500');

                    // Update standard shipping label if it exists
                    const standardRateEl = document.querySelector('input[name="shipping"][value="standard"]')?.closest('label')?.querySelector('.font-semibold.text-secondary:last-child');
                    if (standardRateEl) standardRateEl.textContent = '₹' + shippingCost;

                    // Auto-fill city/state if available and valid
                    if (data.city && data.city !== 'Unknown') {
                        document.querySelector('input[name="city"]').value = data.city;
                    }
                    if (data.state && data.state !== 'Unknown') {
                        const stateSelect = document.querySelector('select[name="state"]');
                        if (stateSelect) {
                            const option = Array.from(stateSelect.options).find(opt => opt.value.toLowerCase() === data.state.toLowerCase());
                            if (option) stateSelect.value = option.value;
                        }
                    }
                    
                    saveFormData(); // Save auto-filled data
                } else {
                    statusDiv.textContent = '✕ ' + (data.message || 'Delivery not available to this pincode');
                    statusDiv.classList.remove('text-gray-400', 'text-green-500', 'hidden');
                    statusDiv.classList.add('text-red-500');
                    shippingCost = 0;
                    document.getElementById('summary-shipping').textContent = '₹0';
                    updateTotal();
                }
            })
            .catch(error => {
                statusDiv.textContent = '✕ Error checking pincode serviceability';
                statusDiv.classList.remove('text-gray-400', 'text-green-500', 'hidden');
                statusDiv.classList.add('text-red-500');
                console.error('Pincode check error:', error);
            });
        }

        function updateTotal() {
            const total = Math.round(subtotal + tax + shippingCost - discount);
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
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(async response => {
                if (response.status === 401) {
                    handleAuthError();
                    return;
                }
                if (response.redirected) {
                    sessionStorage.removeItem('checkout_form_data'); // Clear on success
                    window.location.href = response.url;
                    return;
                }
                
                const contentType = response.headers.get("content-type");
                if (!response.ok) {
                    if (response.status === 429) {
                        throw new Error('An order is already being processed. Please wait.');
                    }
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Checkout failed');
                    }
                    throw new Error('Server error during checkout. Please try again.');
                }

                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                }
                throw new Error('Invalid response from server');
            })
            .then(data => {
                if (data && data.success) {
                    sessionStorage.removeItem('checkout_form_data');
                    window.location.href = '{{ route("customer.checkout.index") }}/confirmation/' + data.order.id;
                } else if (data && data.message) {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Something went wrong. Please try again.');
            });
        }

        function initiateOnlinePayment() {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            data.payment_method = 'online';

            fetch('{{ route("customer.checkout.razorpay.order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(async response => {
                if (response.status === 401) {
                    handleAuthError();
                    return;
                }
                
                const contentType = response.headers.get("content-type");
                if (!response.ok) {
                    if (response.status === 429) {
                        throw new Error('Too many requests. Please wait.');
                    }
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Failed to initiate payment');
                    }
                    throw new Error('Server error initializing payment. Please try again.');
                }

                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                }
                throw new Error('Invalid response from server');
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
            })
            .catch(error => {
                console.error('Payment Error:', error);
                alert(error.message || 'Failed to initiate payment. Please try again.');
            });
        }

        function submitPaymentResponse(paymentResponse) {
            fetch('{{ route("customer.checkout.payment.callback") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(paymentResponse)
            })
            .then(async response => {
                if (response.status === 401) {
                    handleAuthError();
                    return;
                }
                if (response.redirected) {
                    sessionStorage.removeItem('checkout_form_data');
                    window.location.href = response.url;
                    return;
                }

                const contentType = response.headers.get("content-type");
                if (!response.ok) {
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const errorData = await response.json();
                        throw new Error(errorData.message || 'Payment verification failed');
                    }
                    throw new Error('Server error verifying payment.');
                }
                
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json();
                }
                // If not JSON and not redirected, it might be a confirmation page body if not handled by redirect
                throw new Error('Invalid response during payment verification');
            })
            .then(data => {
                if (data && data.success && data.redirect_url) {
                    sessionStorage.removeItem('checkout_form_data');
                    window.location.href = data.redirect_url;
                }
            })
            .catch(error => {
                console.error('Callback Error:', error);
                alert(error.message || 'Payment verification failed. Please contact support.');
            });
        }
        // Promo Code Logic
        window.selectPromoCode = function(code) {
            const input = document.getElementById('promoCode');
            if (input) input.value = code;
            applyCoupon(code);
        };

        const toggleBtn = document.getElementById('togglePromoBtn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const content = document.getElementById('promoContent');
                const chevron = document.getElementById('promoChevron');
                content.classList.toggle('hidden');
                chevron.textContent = content.classList.contains('hidden') ? '▼' : '▲';
            });
        }

        const applyBtn = document.getElementById('applyPromo');
        if (applyBtn) {
            applyBtn.addEventListener('click', function() {
                const code = document.getElementById('promoCode').value.trim();
                if (!code) {
                    alert('Please enter a promo code');
                    return;
                }
                applyCoupon(code);
            });
        }

        const removeBtn = document.getElementById('removePromo');
        if (removeBtn) {
            removeBtn.addEventListener('click', async function() {
                this.disabled = true;
                this.textContent = '...';
                try {
                    const response = await fetch('{{ route("customer.cart.remove-coupon") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error removing coupon:', error);
                    alert('Failed to remove promo code');
                    this.disabled = false;
                    this.innerHTML = `<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Remove`;
                }
            });
        }

        async function applyCoupon(code) {
            const btn = document.getElementById('applyPromo');
            if (!btn) return;
            
            const originalText = btn.textContent;
            btn.disabled = true;
            btn.textContent = '...';

            try {
                const response = await fetch('{{ route("customer.cart.apply-coupon") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ coupon_code: code })
                });

                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to apply coupon');
                    btn.disabled = false;
                    btn.textContent = originalText;
                }
            } catch (error) {
                console.error('Error applying coupon:', error);
                alert('Error applying coupon. Please try again.');
                btn.disabled = false;
                btn.textContent = originalText;
            }
        }
    });
</script>
@endpush
@endsection
