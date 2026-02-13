@extends('customer.layouts.master')

@section('title', 'My Orders - Fashion Store')

@section('content')
<div class="account-container max-w-7xl mx-auto px-4 py-8 mt-16">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">My Orders</h1>
            <p class="text-gray-300">Track and manage your orders and returns.</p>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <div class="stat text-right border-r border-gray-800 pr-4">
                <p class="text-gray-500 uppercase tracking-wider font-bold text-[10px]">Total Spent</p>
                <p class="text-white font-bold text-lg">₹{{ number_format($totalSpent, 2) }}</p>
            </div>
            <div class="stat text-right">
                <p class="text-gray-500 uppercase tracking-wider font-bold text-[10px]">Orders</p>
                <p class="text-white font-bold text-lg">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Status Filters -->
    <div class="flex flex-wrap gap-2 mb-8 order-filters">
        <a href="{{ route('customer.account.orders') }}" 
            class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ !request()->routeIs('customer.account.orders.filter') ? 'bg-white text-black' : 'bg-gray-900 text-gray-400 hover:text-white border border-gray-800' }}">
            All
        </a>
        @foreach($statusCounts as $statusName => $count)
            @if($count > 0 || request()->segment(4) == $statusName)
                <a href="{{ route('customer.account.orders.filter', $statusName) }}" 
                    class="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 {{ request()->segment(4) == $statusName ? 'bg-white text-black' : 'bg-gray-900 text-gray-400 hover:text-white border border-gray-800' }}">
                    {{ ucfirst($statusName) }} ({{ $count }})
                </a>
            @endif
        @endforeach
    </div>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="order-card bg-black border border-gray-800 rounded-xl overflow-hidden hover:border-gray-600 transition-colors">
                    <div class="p-6 bg-gray-900/50 border-b border-gray-800 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-6">
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Order Placed</p>
                                <p class="text-white font-semibold text-sm">{{ $order->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Total Amount</p>
                                <p class="text-white font-semibold text-sm">₹{{ number_format($order->grand_total, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Order #</p>
                                <p class="text-white font-semibold text-sm">{{ $order->order_number }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('customer.account.orders.details', $order->id) }}" class="text-white font-bold text-sm bg-gray-800 px-4 py-2 rounded-lg hover:bg-white hover:text-black transition-all">
                                View Order
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <span class="w-3 h-3 rounded-full mr-3 
                                {{ $order->status == 'delivered' ? 'bg-green-500' : 
                                   ($order->status == 'pending' ? 'bg-yellow-500' : 
                                   ($order->status == 'cancelled' ? 'bg-red-500' : 'bg-blue-500')) }}"></span>
                            <h4 class="text-lg font-bold text-white uppercase tracking-tight">{{ ucfirst($order->status) }}</h4>
                            @if($order->status == 'delivered')
                                <p class="text-gray-400 text-sm ml-4">on {{ $order->updated_at->format('M d, Y') }}</p>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 overflow-x-auto pb-2">
                            @foreach($order->items as $item)
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-900 border border-gray-800 rounded-lg overflow-hidden flex items-center justify-center p-2">
                                    {{-- Assuming we have access to images, otherwise placeholder --}}
                                    <i class="fas fa-shopping-bag text-gray-700 text-xl"></i>
                                </div>
                            @endforeach
                            @if($order->items->count() > 4)
                                <div class="flex-shrink-0 w-20 h-20 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center">
                                    <p class="text-gray-400 font-bold">+{{ $order->items->count() - 4 }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-black border border-gray-800 rounded-lg p-12 text-center mt-8">
            <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-bag text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">No orders found</h3>
            <p class="text-gray-400 mb-8 max-w-md mx-auto">You haven't placed any orders matching this filter yet.</p>
            <a href="{{ route('customer.products.index') }}" class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors inline-block">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection
