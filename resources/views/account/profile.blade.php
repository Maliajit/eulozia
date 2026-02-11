@extends('layouts.master')

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
                    <h3 class="text-xl font-semibold text-white">John Doe</h3>
                    <p class="text-gray-300">john.doe@example.com</p>
                    <p class="text-sm text-gray-400 mt-1">Member since Jan 2024</p>
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
                    <span class="notification bg-white text-black text-xs px-2 py-1 rounded-full">5</span>
                </button>
                <button data-tab="addresses"
                    class="tab-btn nav-item flex items-center w-full px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                    <i class="fas fa-map-marker-alt mr-3"></i>
                    Addresses
                </button>
                <a href="#"
                    class="nav-item logout flex items-center px-4 py-3 rounded-lg text-red-400 hover:bg-gray-800 transition-all duration-300"
                    onclick="return confirmLogout()">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="account-content bg-black rounded-lg border border-gray-800 p-6 lg:col-span-3">
            <!-- Dashboard Tab -->
            <div class="tab-pane active" id="dashboard">
                <div class="content-header mb-8">
                    <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
                    <p class="text-gray-300">Welcome back, John Doe! Here's your overview.</p>
                </div>

                <div class="stats-grid grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center">
                        <div class="stat-icon orders w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shopping-bag text-white text-xl"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="text-2xl font-bold text-white">12</h3>
                            <p class="text-gray-300">Total Orders</p>
                        </div>
                    </div>
                    <!-- Other stats cards -->
                </div>
                
                <!-- Recent Orders Preview -->
                <div class="content-section mb-8">
                    <div class="section-header flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Recent Orders</h2>
                        <button onclick="document.querySelector('[data-tab=orders]').click()" class="view-all text-white hover:text-gray-300 font-semibold">View All</button>
                    </div>
                    <!-- Order cards would go here -->
                </div>
            </div>

            <!-- Other Tab Panes (Profile, Orders, Addresses) would go here following the same structure -->
            <div class="tab-pane hidden" id="profile">
                <h1 class="text-3xl font-bold text-white mb-6">Profile Settings</h1>
                <!-- Profile Form -->
            </div>
            
            <div class="tab-pane hidden" id="orders">
                <h1 class="text-3xl font-bold text-white mb-6">My Orders</h1>
                <!-- Orders List -->
            </div>

            <div class="tab-pane hidden" id="addresses">
                <h1 class="text-3xl font-bold text-white mb-6">Saved Addresses</h1>
                <!-- Address Management -->
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-tab');

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
                });
                document.getElementById(target).classList.remove('hidden');
            });
        });
    });

    function confirmLogout() {
        return confirm('Are you sure you want to logout?');
    }
</script>
@endpush
