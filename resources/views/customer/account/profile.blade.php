@extends('customer.layouts.master')

@section('title', 'My Account - Fashion Store')

@section('content')
    <div class="account-container max-w-7xl mx-auto px-4 py-8 mt-16">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <aside class="account-sidebar bg-black rounded-lg border border-gray-800 p-6 lg:col-span-1">
                <div class="user-profile text-center mb-8">
                    <div class="avatar w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-3xl text-white"></i>
                    </div>
                    <div class="user-info">
                        <h3 class="text-xl font-semibold text-white">{{ $customer->name }}</h3>
                        <p class="text-gray-300">{{ $customer->email }}</p>
                        <p class="text-sm text-gray-400 mt-1">Member since {{ $customer->created_at->format('M Y') }}</p>
                    </div>
                </div>

                <nav class="sidebar-nav space-y-2">
                    <button data-tab="dashboard"
                        class="tab-btn nav-item flex items-center w-full px-4 py-3 rounded-lg bg-white text-black transition-all duration-300">
                        <i class="fas fa-chart-line mr-3"></i>
                        Dashboard
                    </button>
                    <button data-tab="profile"
                        class="tab-btn nav-item flex items-center w-full px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                        <i class="fas fa-user-edit mr-3"></i>
                        Profile Settings
                    </button>
                    <button data-tab="orders"
                        class="tab-btn nav-item flex items-center justify-between w-full px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-bag mr-3"></i>
                            My Orders
                        </div>
                        @if($totalOrders > 0)
                            <span
                                class="notification bg-white text-black text-xs px-2 py-1 rounded-full">{{ $totalOrders }}</span>
                        @endif
                    </button>
                    <button data-tab="addresses"
                        class="tab-btn nav-item flex items-center w-full px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                        <i class="fas fa-map-marker-alt mr-3"></i>
                        Addresses
                    </button>

                    <a href="#"
                        class="nav-item logout flex items-center px-4 py-3 rounded-lg text-red-400 hover:bg-gray-800 transition-all duration-300"
                        onclick="event.preventDefault(); confirmLogout();">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </a>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="account-content bg-black rounded-lg border border-gray-800 p-6 lg:col-span-3">
                <div class="tab-pane {{ $status ? '' : 'active' }}" id="dashboard">
                    <div class="content-header mb-8">
                        <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
                        <p class="text-gray-300">Welcome back, {{ explode(' ', $customer->name)[0] }}! Here's your overview.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded-lg mb-6 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="stats-grid grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center">
                            <div
                                class="stat-icon orders w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-shopping-bag text-white text-xl"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="text-2xl font-bold text-white">{{ $totalOrders }}</h3>
                                <p class="text-gray-300">Total Orders</p>
                            </div>
                        </div>

                        <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center">
                            <div
                                class="stat-icon wishlist w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-heart text-white text-xl"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="text-2xl font-bold text-white">{{ $wishlistCount }}</h3>
                                <p class="text-gray-300">In Wishlist</p>
                            </div>
                        </div>

                        <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center">
                            <div
                                class="stat-icon cart w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-wallet text-white text-xl"></i>
                            </div>
                            <div class="stat-info">
                                <h3 class="text-2xl font-bold text-white">₹{{ number_format($totalSpent) }}</h3>
                                <p class="text-gray-300">Total Spent</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Preview -->
                    <div class="content-section mb-8">
                        <div class="section-header flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-white">Recent Orders</h2>
                            @if($totalOrders > 0)
                                <button onclick="document.querySelector('[data-tab=orders]').click()"
                                    class="view-all text-white hover:text-gray-300 font-semibold">View All</button>
                            @endif
                        </div>

                        @if($recentOrders->count() > 0)
                            <div class="orders-list space-y-4">
                                @foreach($recentOrders as $order)
                                                <div
                                                    class="order-card bg-gray-900 border border-gray-800 rounded-lg p-4 flex flex-wrap items-center justify-between gap-4">
                                                    <div class="order-info">
                                                        <h4 class="text-white font-semibold">Order #{{ $order->order_number }}</h4>
                                                        <p class="text-sm text-gray-400">{{ $order->created_at->format('M d, Y') }}</p>
                                                    </div>
                                                    <div class="order-status">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                                                                            {{ $order->status == 'delivered' ? 'bg-green-500/10 text-green-500' :
                                    ($order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500' :
                                        ($order->status == 'cancelled' ? 'bg-red-500/10 text-red-500' : 'bg-blue-500/10 text-blue-500')) }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </div>
                                                    <div class="order-total">
                                                        <p class="text-white font-bold">₹{{ number_format($order->grand_total) }}</p>
                                                        <p class="text-xs text-gray-400">{{ $order->items->count() }} items</p>
                                                    </div>
                                                    <div class="order-actions">
                                                        <a href="{{ route('customer.account.orders.details', $order->id) }}"
                                                            class="text-accent hover:text-white text-sm font-medium transition-colors">View
                                                            Details</a>
                                                    </div>
                                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-900 border border-gray-800 rounded-lg p-8 text-center">
                                <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-shopping-bag text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-white font-semibold mb-2">No orders yet</h3>
                                <p class="text-gray-400 mb-6">Start shopping to see your orders here.</p>
                                <a href="{{ route('customer.products.index') }}"
                                    class="inline-block bg-accent text-primary px-6 py-2 rounded-lg font-bold hover:bg-white transition-colors">
                                    Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Profile Tab Panes -->
                <div class="tab-pane hidden" id="profile">
                    <div class="content-header mb-8">
                        <h1 class="text-3xl font-bold text-white mb-2">Profile Settings</h1>
                        <p class="text-gray-300">Update your personal information and contact details.</p>
                    </div>

                    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                        <form action="{{ route('customer.account.profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group">
                                    <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}"
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>
                                <div class="form-group">
                                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>
                                <div class="form-group">
                                    <label for="mobile" class="block text-sm font-medium text-gray-400 mb-2">Mobile
                                        Number</label>
                                    <input type="text" name="mobile" id="mobile"
                                        value="{{ old('mobile', $customer->mobile) }}"
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane {{ $status ? 'active' : 'hidden' }}" id="orders">
                    <div class="content-header mb-8">
                        <h1 class="text-3xl font-bold text-white mb-2">My Orders</h1>
                        <p class="text-gray-300">View and track all your orders.</p>
                    </div>

                    <!-- Status Filters -->
                    <div class="flex flex-wrap gap-2 mb-8 order-filters">
                        <a href="{{ route('customer.account.index') }}#orders"
                            class="px-4 py-2 rounded-full text-xs md:text-sm font-semibold transition-all duration-300 {{ !$status ? 'bg-white text-black' : 'bg-gray-900 text-gray-400 hover:text-white border border-gray-800' }}">
                            All
                        </a>
                        @foreach($statusCounts as $statusName => $count)
                            @if($count > 0 || $status == $statusName)
                                <a href="{{ route('customer.account.filter', $statusName) }}#orders"
                                    class="px-4 py-2 rounded-full text-xs md:text-sm font-semibold transition-all duration-300 {{ $status == $statusName ? 'bg-white text-black' : 'bg-gray-900 text-gray-400 hover:text-white border border-gray-800' }}">
                                    {{ ucfirst($statusName) }} ({{ $count }})
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if($allOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($allOrders as $order)
                                        <div
                                            class="order-card bg-gray-900 border border-gray-800 rounded-lg p-4 flex flex-wrap items-center justify-between gap-4">
                                            <div class="order-info">
                                                <h4 class="text-white font-semibold text-sm md:text-base">Order #{{ $order->order_number }}
                                                </h4>
                                                <p class="text-[10px] md:text-xs text-gray-400">{{ $order->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                            <div class="order-status">
                                                <span
                                                    class="px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-semibold
                                                                                {{ $order->status == 'delivered' ? 'bg-green-500/10 text-green-500' :
                                ($order->status == 'pending' ? 'bg-yellow-500/10 text-yellow-500' :
                                    ($order->status == 'cancelled' ? 'bg-red-500/10 text-red-500' : 'bg-blue-500/10 text-blue-500')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                            <div class="order-total">
                                                <p class="text-white font-bold text-sm md:text-base">
                                                    ₹{{ number_format($order->grand_total) }}</p>
                                                <p class="text-[10px] md:text-xs text-gray-400">{{ $order->items->count() }} items</p>
                                            </div>
                                            <div class="order-actions">
                                                <a href="{{ route('customer.account.orders.details', $order->id) }}"
                                                    class="text-accent hover:text-white text-xs md:text-sm font-medium transition-colors">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                            @endforeach

                            <div class="mt-8 pagination-container">
                                {{ $allOrders->fragment('orders')->links() }}
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-900 border border-gray-800 rounded-lg p-8 md:p-12 text-center">
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 bg-black border border-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-shopping-bag text-gray-500 text-2xl md:text-3xl"></i>
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold text-white mb-2">No orders found</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto text-sm md:text-base">You haven't placed any orders
                                matching this filter yet.</p>
                            <a href="{{ route('customer.products.index') }}"
                                class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors inline-block text-sm">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>

                <div class="tab-pane hidden" id="addresses">
                    <div class="section-header flex justify-between items-center mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Saved Addresses</h1>
                            <p class="text-gray-300">Manage your shipping and billing addresses for faster checkout.</p>
                        </div>
                        <button onclick="openAddressModal()"
                            class="bg-white text-black px-6 py-2 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Add New Address
                        </button>
                    </div>

                    @if($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($addresses as $address)
                                <div class="address-card bg-gray-900 border border-gray-800 rounded-lg p-6 relative group">
                                    @if($address->is_default)
                                        <span
                                            class="absolute top-4 right-4 bg-white text-black text-[10px] font-bold px-2 py-1 rounded-full uppercase">Default</span>
                                    @endif

                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center mr-3">
                                            <i
                                                class="fas fa-{{ $address->type == 'shipping' ? 'truck' : ($address->type == 'billing' ? 'file-invoice-dollar' : 'map-marker-alt') }} text-gray-400"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-white font-bold">{{ $address->name }}</h4>
                                            <span
                                                class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">{{ $address->type }}</span>
                                        </div>
                                    </div>

                                    <div class="space-y-1 mb-6">
                                        <p class="text-gray-400 text-sm">{{ $address->address }}</p>
                                        <p class="text-gray-400 text-sm">{{ $address->city }}, {{ $address->state }}
                                            {{ $address->pincode }}
                                        </p>
                                        <p class="text-gray-400 text-sm">{{ $address->country }}</p>
                                        <p class="text-gray-400 text-sm mt-2"><i class="fas fa-phone mr-1 text-gray-600"></i>
                                            {{ $address->mobile }}</p>
                                    </div>

                                    <div class="flex items-center gap-4 pt-4 border-t border-gray-800">
                                        <button onclick="editAddress({{ json_encode($address) }})"
                                            class="text-gray-400 hover:text-white text-sm font-medium transition-colors">Edit</button>

                                        <form action="{{ route('customer.account.addresses.delete', $address->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this address?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">Delete</button>
                                        </form>

                                        @if(!$address->is_default)
                                            <form action="{{ route('customer.account.addresses.set-default', $address->id) }}"
                                                method="POST" class="inline ml-auto">
                                                @csrf
                                                <button type="submit"
                                                    class="text-accent hover:text-white text-sm font-medium transition-colors">Set
                                                    Default</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-900 border border-gray-800 rounded-lg p-12 text-center">
                            <div
                                class="w-20 h-20 bg-black border border-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-map-marker-alt text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-2">No addresses saved yet</h3>
                            <p class="text-gray-400 mb-8 max-w-md mx-auto text-sm">Add your shipping and billing addresses to
                                make your checkout process faster and easier.</p>
                            <button onclick="openAddressModal()"
                                class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                                Add Your First Address
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Address Modal -->
                <div id="addressModal"
                    class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
                    <div
                        class="bg-gray-900 border border-gray-800 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                        <div
                            class="p-6 border-b border-gray-800 flex justify-between items-center sticky top-0 bg-gray-900 z-10">
                            <h2 id="modalTitle" class="text-2xl font-bold text-white">Add New Address</h2>
                            <button onclick="closeAddressModal()" class="text-gray-400 hover:text-white transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>

                        <form id="addressForm" method="POST" action="{{ route('customer.account.addresses.store') }}"
                            class="p-6 space-y-6">
                            @csrf
                            <div id="methodField"></div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="form-group md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                                    <input type="text" name="name" id="address_name" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Mobile Number</label>
                                    <input type="text" name="mobile" id="address_mobile" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);"
                                        inputmode="numeric" maxlength="10" minlength="10">
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Address Type</label>
                                    <select name="type" id="address_type" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                        <option value="shipping">Shipping</option>
                                        <option value="billing">Billing</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>

                                <div class="form-group md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Full Address</label>
                                    <textarea name="address" id="address_text" rows="3" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors"></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">City</label>
                                    <input type="text" name="city" id="address_city" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">State</label>
                                    <input type="text" name="state" id="address_state" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Pincode</label>
                                    <input type="text" name="pincode" id="address_pincode" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 6);"
                                        inputmode="numeric" maxlength="6" minlength="6">
                                </div>

                                <div class="form-group">
                                    <label class="block text-sm font-medium text-gray-400 mb-2">Country</label>
                                    <input type="text" name="country" id="address_country" value="IN" maxlength="2" required
                                        class="w-full bg-black border border-gray-800 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-white transition-colors">
                                </div>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_default" id="address_is_default" value="1"
                                    class="w-4 h-4 bg-black border-gray-800 rounded text-white focus:ring-0">
                                <label for="address_is_default" class="ml-2 text-sm text-gray-400">Set as default
                                    address</label>
                            </div>

                            <div class="flex justify-end gap-4 pt-6 border-t border-gray-800">
                                <button type="button" onclick="closeAddressModal()"
                                    class="px-6 py-3 rounded-lg text-white hover:bg-gray-800 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="bg-white text-black px-8 py-3 rounded-lg font-bold hover:bg-gray-200 transition-colors">
                                    Save Address
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanes = document.querySelectorAll('.tab-pane');

            function activateTab(target) {
                const btn = document.querySelector(`[data-tab="${target}"]`);
                if (!btn) return;

                // Update buttons
                tabBtns.forEach(b => {
                    b.classList.remove('bg-white', 'text-black');
                    b.classList.add('text-white', 'hover:bg-gray-800');
                });
                btn.classList.add('bg-white', 'text-black');
                btn.classList.remove('text-white', 'hover:bg-gray-800');

                // Update panes
                tabPanes.forEach(pane => {
                    pane.classList.add('hidden');
                    pane.classList.remove('active');
                });
                const targetPane = document.getElementById(target);
                if (targetPane) {
                    targetPane.classList.remove('hidden');
                    targetPane.classList.add('active');
                }
            }

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-tab');
                    activateTab(target);
                    // Update hash without scrolling
                    history.pushState(null, null, `#${target}`);
                });
            });

            // Check hash on load
            const hash = window.location.hash.substring(1);
            if (hash) {
                activateTab(hash);
            } else if (document.querySelector('.tab-pane.active')) {
                // Already handled by server-side class injection
            }
        });



        // Address Management logic
        const modal = document.getElementById('addressModal');
        const form = document.getElementById('addressForm');
        const title = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        const storeUrl = "{{ route('customer.account.addresses.store') }}";

        function openAddressModal() {
            if (!modal) return;
            title.innerText = 'Add New Address';
            form.action = storeUrl;
            methodField.innerHTML = '';
            form.reset();
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddressModal() {
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function editAddress(address) {
            if (!modal) return;
            title.innerText = 'Edit Address';
            form.action = `/account/addresses/${address.id}`;
            methodField.innerHTML = '@method("PUT")';

            document.getElementById('address_name').value = address.name;
            document.getElementById('address_mobile').value = address.mobile;
            document.getElementById('address_type').value = address.type;
            document.getElementById('address_text').value = address.address;
            document.getElementById('address_city').value = address.city;
            document.getElementById('address_state').value = address.state;
            document.getElementById('address_pincode').value = address.pincode;
            document.getElementById('address_country').value = address.country;
            document.getElementById('address_is_default').checked = address.is_default;

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        if (modal) {
            // Close modal on outside click
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeAddressModal();
            });
        }
    </script>
@endpush