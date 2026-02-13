@extends('customer.layouts.minimal')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-gray-950 text-secondary">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Order Confirmed!</h1>
        <p class="mt-4 text-lg text-gray-400">Thanks for your order, #{{ $order->order_number }}. We'll notify you as soon as it ships.</p>
    </div>

    <div class="bg-gray-900 shadow overflow-hidden sm:rounded-lg border border-gray-800">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-white">Order Summary</h3>
        </div>
        <div class="border-t border-gray-800 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-800">
                @foreach($order->items as $item)
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">{{ $item->product_name }} (x{{ $item->quantity }})</dt>
                    <dd class="mt-1 text-sm text-secondary sm:mt-0 sm:col-span-2">₹{{ number_format($item->total) }}</dd>
                </div>
                @endforeach

                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">Subtotal</dt>
                    <dd class="mt-1 text-sm text-secondary sm:mt-0 sm:col-span-2">₹{{ number_format($order->subtotal) }}</dd>
                </div>

                @if($order->discount_total > 0)
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-green-500">Discount</dt>
                    <dd class="mt-1 text-sm text-green-500 sm:mt-0 sm:col-span-2">- ₹{{ number_format($order->discount_total) }}</dd>
                </div>
                @endif

                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-400">Shipping</dt>
                    <dd class="mt-1 text-sm text-secondary sm:mt-0 sm:col-span-2">₹{{ number_format($order->shipping_total) }}</dd>
                </div>

                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-800/50">
                    <dt class="text-sm font-bold text-white">Grand Total</dt>
                    <dd class="mt-1 text-sm font-bold text-accent sm:mt-0 sm:col-span-2">₹{{ number_format($order->grand_total) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-10 bg-gray-900 shadow overflow-hidden sm:rounded-lg border border-gray-800">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-white">Shipping Address</h3>
        </div>
        <div class="border-t border-gray-800 px-4 py-5 sm:px-6">
            <p class="text-sm text-secondary">
                {{ $order->shipping_address['name'] ?? '' }}<br>
                {{ $order->shipping_address['address'] ?? '' }}<br>
                {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} - {{ $order->shipping_address['pincode'] ?? '' }}<br>
                Phone: {{ $order->shipping_address['mobile'] ?? '' }}
            </p>
        </div>
    </div>

    <div class="mt-12 text-center">
        <a href="{{ route('customer.account.orders') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-accent hover:bg-accent/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-all">
            Track Your Order
        </a>
    </div>
</div>
@endsection
