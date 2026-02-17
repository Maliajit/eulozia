@extends('customer.layouts.master')

@section('title', 'Order Details - Fashion Store')

@section('content')
    <div class="account-container max-w-7xl mx-auto px-4 py-8 mt-16">
        <div class="mb-8">
            <a href="{{ route('customer.account.index') }}#orders"
                class="text-gray-400 hover:text-white flex items-center gap-2 mb-4 transition-colors text-sm">
                <i class="fas fa-arrow-left"></i> Back to My Orders
            </a>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">Order #{{ $order->order_number }}</h1>
                    <p class="text-gray-500 text-xs md:text-sm">Placed on {{ $order->created_at->format('M d, Y at H:i') }}</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    @if(in_array($order->status, ['pending', 'confirmed']))
                        <form action="{{ route('customer.account.orders.cancel', $order->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            <input type="hidden" name="cancellation_reason" value="Cancelled by user from account page.">
                            <button type="submit"
                                class="w-full text-red-400 hover:text-red-300 border border-red-500/30 px-6 py-2.5 rounded-lg font-semibold transition-all text-sm">
                                Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-8 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Details -->
            <div class="lg:col-span-2 space-y-6 md:space-y-8">
                <!-- Order Status Timeline -->
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 md:p-8">
                    <h3 class="text-lg md:text-xl font-bold text-white mb-8">Order Status</h3>
                    <div class="relative">
                        <div class="absolute left-3.5 md:left-4 top-0 bottom-0 w-0.5 bg-gray-800"></div>
                        <div class="space-y-8 md:space-y-10">
                            @foreach($statusHistory as $history)
                                <div class="relative pl-10 md:pl-12">
                                    <span
                                        class="absolute left-0 w-7 h-7 md:w-8 md:h-8 rounded-full bg-gray-800 border-4 border-black flex items-center justify-center z-10">
                                        <i class="fas fa-check text-[8px] md:text-[10px] text-white"></i>
                                    </span>
                                    <div class="bg-black/40 border border-gray-800 p-4 rounded-lg">
                                        <h4 class="text-white font-bold uppercase tracking-tight text-xs md:text-sm">
                                            {{ ucfirst($history->status) }}</h4>
                                        <p class="text-gray-500 text-[10px] md:text-xs mt-1">{{ $history->created_at->format('M d, Y - H:i') }}
                                        </p>
                                        @if($history->notes)
                                            <p class="text-gray-400 text-xs md:text-sm mt-3 leading-relaxed">{{ $history->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Items List -->
                <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
                    <div class="p-5 md:p-6 border-b border-gray-800">
                        <h3 class="text-lg md:text-xl font-bold text-white">Order Items ({{ $order->items->count() }})</h3>
                    </div>
                    <div class="divide-y divide-gray-800">
                        @foreach($order->items as $item)
                            <div class="p-5 md:p-6 flex flex-col sm:flex-row gap-5 md:gap-6">
                                <div
                                    class="w-20 h-20 md:w-24 md:h-24 bg-black border border-gray-800 rounded-lg overflow-hidden flex items-center justify-center p-2 flex-shrink-0 mx-auto sm:mx-0">
                                    @if($item->variant && $item->variant->display_image)
                                        <img src="{{ $item->variant->display_image }}" alt="{{ $item->product_name }}"
                                            class="w-full h-full object-cover rounded">
                                    @else
                                        <i class="fas fa-shopping-bag text-gray-800 text-2xl md:text-3xl"></i>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <div class="flex flex-col sm:flex-row justify-between items-start mb-3 gap-2">
                                        <h4 class="text-white font-bold text-base md:text-lg leading-tight">
                                            {{ $item->product_name ?? 'Product' }}</h4>
                                        <p class="text-white font-bold text-base md:text-lg">₹{{ number_format($item->unit_price, 2) }}</p>
                                    </div>
                                    @if($item->attributes && is_array($item->attributes))
                                        <div class="flex flex-wrap gap-x-4 gap-y-2 mb-4">
                                            @foreach($item->attributes as $key => $value)
                                                <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">{{ $key }}: <span
                                                            class="text-gray-300">{{ $value }}</span></p>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="flex justify-between items-center text-xs md:text-sm">
                                        <p class="text-gray-500">Quantity: <span class="text-white">{{ $item->quantity }}</span>
                                        </p>
                                        <p class="text-gray-500">Total: <span
                                                class="text-white font-bold">₹{{ number_format($item->total, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="p-5 md:p-6 bg-black/40 border-t border-gray-800 flex justify-end">
                        <div class="w-full md:max-w-xs space-y-3">
                            <div class="flex justify-between text-gray-400 text-xs md:text-sm">
                                <span>Subtotal</span>
                                <span class="text-white">₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400 text-xs md:text-sm">
                                <span>Shipping</span>
                                <span class="text-white">₹{{ number_format($order->shipping_total, 2) }}</span>
                            </div>
                            @if($order->tax_total > 0)
                                <div class="flex justify-between text-gray-400 text-xs md:text-sm">
                                    <span>Tax</span>
                                    <span class="text-white">₹{{ number_format($order->tax_total, 2) }}</span>
                                </div>
                            @endif
                            @if($order->discount_total > 0)
                                <div class="flex justify-between text-green-500 text-xs md:text-sm">
                                    <span>Discount</span>
                                    <span>-₹{{ number_format($order->discount_total, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-white font-bold text-base md:text-lg pt-3 border-t border-gray-800">
                                <span>Grand Total</span>
                                <span>₹{{ number_format($order->grand_total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Details -->
            <div class="space-y-6 md:space-y-8">
                <!-- Shipping Info -->
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                    <h3 class="text-sm md:text-base font-bold text-white mb-6 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-truck text-xs text-gray-500"></i> Shipping Address
                    </h3>
                    @php $ship = $shippingAddress @endphp
                    <p class="text-white font-bold mb-1 text-sm md:text-base">{{ $ship['name'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm mb-1 leading-relaxed">{{ $ship['address'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm mb-1">{{ $ship['city'] ?? '' }}, {{ $ship['state'] ?? '' }}
                        {{ $ship['pincode'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm mb-4">{{ $ship['country'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm"><i class="fas fa-phone mr-1 text-gray-600"></i>
                        {{ $ship['phone'] ?? $ship['mobile'] ?? '' }}</p>
                </div>

                <!-- Billing Info -->
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                    <h3 class="text-sm md:text-base font-bold text-white mb-6 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-file-invoice text-xs text-gray-500"></i> Billing Address
                    </h3>
                    @php $bill = $billingAddress @endphp
                    <p class="text-white font-bold mb-1 text-sm md:text-base">{{ $bill['name'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm mb-1 leading-relaxed">{{ $bill['address'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm mb-1">{{ $bill['city'] ?? '' }}, {{ $bill['state'] ?? '' }}
                        {{ $bill['pincode'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm mb-4">{{ $bill['country'] ?? '' }}</p>
                    <p class="text-gray-400 text-xs md:text-sm"><i class="fas fa-phone mr-1 text-gray-600"></i>
                        {{ $bill['phone'] ?? $bill['mobile'] ?? '' }}</p>
                </div>

                <!-- Payment Info -->
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                    <h3 class="text-sm md:text-base font-bold text-white mb-6 uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-credit-card text-xs text-gray-500"></i> Payment Details
                    </h3>
                    <div class="space-y-4 text-xs md:text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Method</span>
                            <span
                                class="text-white font-bold underline decoration-gray-700 underline-offset-4">{{ strtoupper($order->payment_method) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Status</span>
                            <span
                                class="px-2 py-0.5 rounded text-[9px] md:text-[10px] font-bold uppercase 
                                {{ $order->payment_status == 'paid' ? 'bg-green-500/10 text-green-500 border border-green-500/30' : 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/30' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                        @if($order->payment_id)
                            <div class="flex justify-between gap-4">
                                <span class="text-gray-500 flex-shrink-0">Transaction ID</span>
                                <span class="text-white text-[9px] md:text-[10px] break-all text-right">{{ $order->payment_id }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection