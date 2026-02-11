<?php
$pageTitle = "My Account - PromiseWear";
include 'includes/header.php';
?>

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
                <a href="#dashboard"
                    class="nav-item flex items-center px-4 py-3 rounded-lg bg-white text-black transition-all duration-300">
                    <i class="fas fa-chart-line mr-3"></i>
                    Dashboard
                </a>
                <a href="#profile"
                    class="nav-item flex items-center px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                    <i class="fas fa-user-edit mr-3"></i>
                    Profile Settings
                </a>
                <a href="#orders"
                    class="nav-item flex items-center justify-between px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-bag mr-3"></i>
                        My Orders
                    </div>
                    <span class="notification bg-white text-black text-xs px-2 py-1 rounded-full">5</span>
                </a>
                <a href="#addresses"
                    class="nav-item flex items-center px-4 py-3 rounded-lg text-white hover:bg-gray-800 transition-all duration-300">
                    <i class="fas fa-map-marker-alt mr-3"></i>
                    Addresses
                </a>
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
            <div class="tab-content active" id="dashboard">
                <div class="content-header mb-8">
                    <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
                    <p class="text-gray-300">Welcome back, John Doe! Here's your business overview.</p>
                </div>

                <div class="stats-grid grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center hover:border-gray-700 transition-all duration-300">
                        <div class="stat-icon orders w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-shopping-bag text-white text-xl"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="text-2xl font-bold text-white">12</h3>
                            <p class="text-gray-300">Total Orders</p>
                        </div>
                    </div>
                    <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center hover:border-gray-700 transition-all duration-300">
                        <div class="stat-icon pending w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-clock text-white text-xl"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="text-2xl font-bold text-white">2</h3>
                            <p class="text-gray-300">Pending Orders</p>
                        </div>
                    </div>
                    <div class="stat-card bg-gray-900 border border-gray-800 rounded-lg p-6 flex items-center hover:border-gray-700 transition-all duration-300">
                        <div class="stat-icon spent w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-rupee-sign text-white text-xl"></i>
                        </div>
                        <div class="stat-info">
                            <h3 class="text-2xl font-bold text-white">₹45,670.00</h3>
                            <p class="text-gray-300">Total Spent</p>
                        </div>
                    </div>
                </div>

                <div class="content-section mb-8">
                    <div class="section-header flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Recent Orders</h2>
                        <a href="#orders" class="view-all text-white hover:text-gray-300 font-semibold">View All</a>
                    </div>
                    
                    <div class="orders-list space-y-4">
                        <div class="order-card bg-gray-900 border border-gray-800 rounded-lg p-6 hover:border-gray-700 transition-all duration-300">
                            <div class="order-header flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Order #1001</h4>
                                    <p class="text-gray-300 text-sm">Mar 15, 2024 2:30 PM</p>
                                </div>
                                <span class="status-badge bg-green-900 text-green-300 px-3 py-1 rounded-full text-sm font-medium">Delivered</span>
                            </div>
                            
                            <div class="order-details grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-400">Items</p>
                                    <p class="font-medium text-white">3 items</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Total Amount</p>
                                    <p class="font-medium text-white">₹8,450.00</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Payment</p>
                                    <p class="font-medium text-green-400">Paid</p>
                                </div>
                            </div>
                            
                            <div class="order-actions flex justify-end">
                                <a href="#orders" 
                                   class="text-white hover:text-gray-300 font-semibold text-sm flex items-center"
                                   onclick="switchToOrdersTab()">
                                    View Details
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <div class="order-card bg-gray-900 border border-gray-800 rounded-lg p-6 hover:border-gray-700 transition-all duration-300">
                            <div class="order-header flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Order #1002</h4>
                                    <p class="text-gray-300 text-sm">Mar 12, 2024 10:15 AM</p>
                                </div>
                                <span class="status-badge bg-yellow-900 text-yellow-300 px-3 py-1 rounded-full text-sm font-medium">Processing</span>
                            </div>
                            
                            <div class="order-details grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-400">Items</p>
                                    <p class="font-medium text-white">5 items</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Total Amount</p>
                                    <p class="font-medium text-white">₹12,340.00</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Payment</p>
                                    <p class="font-medium text-green-400">Paid</p>
                                </div>
                            </div>
                            
                            <div class="order-actions flex justify-end">
                                <a href="#orders" 
                                   class="text-white hover:text-gray-300 font-semibold text-sm flex items-center"
                                   onclick="switchToOrdersTab()">
                                    View Details
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-section">
                    <div class="section-header mb-6">
                        <h2 class="text-2xl font-bold text-white">Quick Actions</h2>
                    </div>
                    <div class="quick-actions grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="shop.php"
                            class="action-card bg-gray-900 border border-gray-800 rounded-lg p-6 text-center hover:border-white transition-all duration-300">
                            <i class="fas fa-plus text-3xl text-white mb-3"></i>
                            <span class="font-semibold text-white">Place New Order</span>
                        </a>
                        <a href="#addresses"
                            class="action-card bg-gray-900 border border-gray-800 rounded-lg p-6 text-center hover:border-white transition-all duration-300">
                            <i class="fas fa-map-marker-alt text-3xl text-white mb-3"></i>
                            <span class="font-semibold text-white">Manage Addresses</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Tab -->
            <div class="tab-content hidden" id="profile">
                <div class="content-header mb-8">
                    <h1 class="text-3xl font-bold text-white mb-2">Profile Settings</h1>
                    <p class="text-gray-300">Manage your personal information and account settings</p>
                </div>

                <form class="profile-form space-y-8" method="POST" action="">
                    <div class="form-section">
                        <h3 class="text-xl font-semibold text-white mb-6">Personal Information</h3>
                        <div class="form-row grid grid-cols-1 gap-6 mb-6">
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Full Name *</label>
                                <input type="text" name="full_name" value="John Doe"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    required>
                            </div>
                        </div>
                        <div class="form-row grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Email Address</label>
                                <input type="email" value="john.doe@example.com"
                                    class="form-input w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-400 cursor-not-allowed"
                                    disabled readonly>
                                <p class="text-sm text-gray-400 mt-1">Email cannot be changed</p>
                            </div>
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Phone Number *</label>
                                <input type="tel" name="phone" value="9876543210"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    maxlength="10" pattern="[0-9]{10}" required>
                                <p class="text-sm text-gray-400 mt-1">10-digit phone number</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="text-xl font-semibold text-white mb-6">Business Information</h3>
                        <div class="form-row grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Business Name *</label>
                                <input type="text" name="business_name" value="Fashion Boutique"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    required>
                            </div>
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Business Type *</label>
                                <select name="business_type"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    required>
                                    <option value="boutique" selected>Boutique</option>
                                    <option value="retail_store">Retail Store</option>
                                    <option value="online_store">Online Store</option>
                                    <option value="wholesaler">Wholesaler</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-group">
                            <label class="block text-white font-medium mb-2">Member Since</label>
                            <input type="text" value="January 15, 2024"
                                class="form-input w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-gray-400 cursor-not-allowed"
                                disabled readonly>
                        </div>
                    </div>

                    <div class="form-actions flex justify-end space-x-4">
                        <button type="button"
                            class="btn-secondary border border-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-all duration-300"
                            onclick="resetForm()">Reset</button>
                        <button type="submit"
                            class="btn-primary bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-all duration-300 flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Orders Tab -->
            <div class="tab-content hidden" id="orders">
                <div class="content-header mb-8">
                    <h1 class="text-3xl font-bold text-white mb-2">My Orders</h1>
                    <p class="text-gray-300">Track and manage your orders</p>
                </div>

                <div class="orders-container">
                    <div class="orders-list space-y-6">
                        <div class="order-card bg-gray-900 border border-gray-800 rounded-lg p-6 hover:border-gray-700 transition-all duration-300">
                            <div class="order-header flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Order #1001</h4>
                                    <p class="text-gray-300 text-sm">Mar 15, 2024 2:30 PM</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="status-badge bg-green-900 text-green-300 px-3 py-1 rounded-full text-sm font-medium">Delivered</span>
                                </div>
                            </div>
                            
                            <div class="order-details grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-400">Items</p>
                                    <p class="font-medium text-white">3 items</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Total Amount</p>
                                    <p class="font-medium text-white">₹8,450.00</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Payment</p>
                                    <p class="font-medium text-green-400">Paid</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Shipping</p>
                                    <p class="font-medium text-white">Standard</p>
                                </div>
                            </div>
                            
                            <div class="order-actions flex justify-between items-center">
                                <div class="text-sm text-gray-400">
                                    Order Total: <span class="font-semibold text-white">₹8,450.00</span>
                                </div>
                                <div class="flex space-x-4">
                                    <button onclick="viewOrderDetails(1001)"
                                            class="text-white hover:text-gray-300 font-semibold text-sm flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View Details
                                    </button>
                                    <a href="#" 
                                       class="text-blue-400 hover:text-blue-300 font-semibold text-sm flex items-center">
                                        <i class="fas fa-receipt mr-1"></i> Invoice
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="order-card bg-gray-900 border border-gray-800 rounded-lg p-6 hover:border-gray-700 transition-all duration-300">
                            <div class="order-header flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">Order #1002</h4>
                                    <p class="text-gray-300 text-sm">Mar 12, 2024 10:15 AM</p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="status-badge bg-yellow-900 text-yellow-300 px-3 py-1 rounded-full text-sm font-medium">Processing</span>
                                    <button type="button" 
                                            onclick="confirmCancelOrder(1002)" 
                                            class="cancel-btn text-red-400 hover:text-red-300 text-sm font-semibold flex items-center">
                                        <i class="fas fa-times mr-1"></i> Cancel
                                    </button>
                                </div>
                            </div>
                            
                            <div class="order-details grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-400">Items</p>
                                    <p class="font-medium text-white">5 items</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Total Amount</p>
                                    <p class="font-medium text-white">₹12,340.00</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Payment</p>
                                    <p class="font-medium text-green-400">Paid</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Shipping</p>
                                    <p class="font-medium text-white">Express</p>
                                </div>
                            </div>
                            
                            <div class="order-notes mb-4">
                                <p class="text-sm text-gray-400">Order Notes:</p>
                                <p class="text-white">Please deliver before 5 PM</p>
                            </div>
                            
                            <div class="order-actions flex justify-between items-center">
                                <div class="text-sm text-gray-400">
                                    Order Total: <span class="font-semibold text-white">₹12,340.00</span>
                                </div>
                                <div class="flex space-x-4">
                                    <button onclick="viewOrderDetails(1002)"
                                            class="text-white hover:text-gray-300 font-semibold text-sm flex items-center">
                                        <i class="fas fa-eye mr-1"></i> View Details
                                    </button>
                                    <a href="#" 
                                       class="text-blue-400 hover:text-blue-300 font-semibold text-sm flex items-center">
                                        <i class="fas fa-receipt mr-1"></i> Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Addresses Tab -->
            <div class="tab-content hidden" id="addresses">
                <div class="content-header mb-8">
                    <h1 class="text-3xl font-bold text-white mb-2">Saved Addresses</h1>
                    <p class="text-gray-300">Manage your delivery addresses</p>
                </div>

                <!-- Add Address Button -->
                <div class="mb-6">
                    <button onclick="openAddressModal()"
                        class="bg-white text-black px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-all duration-300 inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Address
                    </button>
                </div>

                <!-- Address List -->
                <div class="addresses-grid grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="address-card bg-gray-900 border-2 border-white rounded-lg p-6 relative hover:border-gray-400 transition-all duration-300">
                        <span class="absolute top-4 right-4 bg-white text-black text-xs px-2 py-1 rounded-full">Default</span>
                        <div class="address-type font-semibold text-white mb-2">Shipping Address</div>
                        <div class="address-details text-gray-300">
                            <p class="font-medium text-white">John Doe</p>
                            <p>9876543210</p>
                            <p class="mt-2">123 Main Street</p>
                            <p>Apartment 4B</p>
                            <p>Landmark: Near Central Park</p>
                            <p>Mumbai, Maharashtra - 400001</p>
                            <p>India</p>
                        </div>
                        <div class="address-actions flex space-x-4 mt-4">
                            <button onclick="editAddress(1)"
                                class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button onclick="deleteAddress(1)"
                                class="text-red-400 hover:text-red-300 text-sm font-semibold flex items-center">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>

                    <div class="address-card bg-gray-900 border border-gray-800 rounded-lg p-6 relative hover:border-gray-700 transition-all duration-300">
                        <div class="address-type font-semibold text-white mb-2">Billing Address</div>
                        <div class="address-details text-gray-300">
                            <p class="font-medium text-white">John Doe</p>
                            <p>9876543210</p>
                            <p class="mt-2">456 Business Avenue</p>
                            <p>Office No. 12</p>
                            <p>Landmark: Opposite Metro Station</p>
                            <p>Delhi, Delhi - 110001</p>
                            <p>India</p>
                        </div>
                        <div class="address-actions flex space-x-4 mt-4">
                            <button onclick="editAddress(2)"
                                class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </button>
                            <button onclick="setDefaultAddress(2)"
                                class="text-green-400 hover:text-green-300 text-sm font-semibold flex items-center">
                                <i class="fas fa-star mr-1"></i> Set Default
                            </button>
                            <button onclick="deleteAddress(2)"
                                class="text-red-400 hover:text-red-300 text-sm font-semibold flex items-center">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Address Modal -->
<div id="addressModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 hidden">
    <div class="bg-black border border-gray-800 rounded-lg shadow-xl w-full max-w-5xl mx-4 max-h-90vh overflow-y-auto">
        <div class="modal-header flex justify-between items-center border-b border-gray-800 px-6 py-4">
            <h3 class="text-xl font-semibold text-white" id="modalTitle">Add New Address</h3>
            <button onclick="closeAddressModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <form id="addressForm" method="POST" action="">
            <div class="modal-body px-6 py-4">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 horizontal-layout">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="input-group">
                            <label class="block text-white font-medium mb-2">Address Type</label>
                            <select name="address_type"
                                class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                required>
                                <option value="shipping">Shipping Address</option>
                                <option value="billing">Billing Address</option>
                                <option value="both">Both Shipping & Billing</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Full Name *</label>
                                <input type="text" name="full_name" id="full_name" value="John Doe"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    required>
                            </div>
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Phone Number *</label>
                                <input type="tel" name="phone" id="phone" value="9876543210"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    maxlength="10" pattern="[0-9]{10}" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <label class="block text-white font-medium mb-2">Address Line 1 *</label>
                            <textarea name="address_line1" id="address_line1"
                                class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                rows="2" required>123 Main Street</textarea>
                        </div>

                        <div class="input-group">
                            <label class="block text-white font-medium mb-2">Address Line 2</label>
                            <textarea name="address_line2" id="address_line2"
                                class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                rows="2">Apartment 4B</textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="input-group">
                            <label class="block text-white font-medium mb-2">Landmark</label>
                            <input type="text" name="landmark" id="landmark" value="Near Central Park"
                                class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">City *</label>
                                <input type="text" name="city" id="city" value="Mumbai"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    required>
                            </div>
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">State *</label>
                                <input type="text" name="state" id="state" value="Maharashtra"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    required>
                            </div>
                            <div class="input-group">
                                <label class="block text-white font-medium mb-2">Pincode *</label>
                                <input type="text" name="pincode" id="pincode" value="400001"
                                    class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                    maxlength="6" pattern="[0-9]{6}" required>
                            </div>
                        </div>

                        <div class="input-group">
                            <label class="block text-white font-medium mb-2">Country</label>
                            <input type="text" name="country" id="country" value="India"
                                class="form-input w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-white focus:border-transparent text-white"
                                required>
                        </div>

                        <div class="input-group pt-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_default" id="is_default" checked
                                    class="form-checkbox h-5 w-5 text-white bg-gray-900 border-gray-700 rounded">
                                <span class="ml-2 text-white">Set as default address</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-t border-gray-800 px-6 py-4 flex justify-end space-x-4">
                <button type="button" onclick="closeAddressModal()"
                    class="btn-secondary border border-gray-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-800 transition-all duration-300">Cancel</button>
                <button type="submit" name="add_address" id="submitAddressBtn"
                    class="btn-primary bg-white text-black px-6 py-2 rounded-lg font-semibold hover:bg-gray-200 transition-all duration-300">Save
                    Address</button>
            </div>
        </form>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 hidden">
    <div class="bg-black border border-gray-800 rounded-lg shadow-xl w-full max-w-4xl mx-4 max-h-90vh overflow-y-auto">
        <div class="modal-header flex justify-between items-center border-b border-gray-800 px-6 py-4">
            <h3 class="text-xl font-semibold text-white">Order Details</h3>
            <button onclick="closeOrderDetailsModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div class="modal-body px-6 py-4" id="orderDetailsContent">
            <!-- Order details content would go here -->
        </div>
    </div>
</div>

<!-- Keep all JavaScript functions exactly the same -->
<script>
    // Address data for editing
    let addresses = [
        {
            id: 1,
            address_type: "shipping",
            full_name: "John Doe",
            phone: "9876543210",
            address_line1: "123 Main Street",
            address_line2: "Apartment 4B",
            landmark: "Near Central Park",
            city: "Mumbai",
            state: "Maharashtra",
            pincode: "400001",
            country: "India",
            is_default: 1
        },
        {
            id: 2,
            address_type: "billing",
            full_name: "John Doe",
            phone: "9876543210",
            address_line1: "456 Business Avenue",
            address_line2: "Office No. 12",
            landmark: "Opposite Metro Station",
            city: "Delhi",
            state: "Delhi",
            pincode: "110001",
            country: "India",
            is_default: 0
        }
    ];

    function confirmCancelOrder(orderId) {
        Swal.fire({
            title: 'Cancel Order?',
            text: 'Are you sure you want to cancel order #' + orderId + '? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Cancel Order',
            cancelButtonText: 'Keep Order',
            reverseButtons: true,
            background: '#000000',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Order Cancelled',
                    text: 'Your order #' + orderId + ' has been cancelled successfully.',
                    icon: 'success',
                    confirmButtonColor: '#ffffff',
                    background: '#000000',
                    color: '#ffffff'
                });
            }
        });
    }
    
    // Address Modal Functions
    function openAddressModal() {
        document.getElementById('addressModal').classList.remove('hidden');
        document.getElementById('modalTitle').textContent = 'Add New Address';
        document.getElementById('addressForm').reset();
        document.getElementById('submitAddressBtn').name = 'add_address';
    }

    function closeAddressModal() {
        document.getElementById('addressModal').classList.add('hidden');
    }

    function editAddress(addressId) {
        const address = addresses.find(addr => addr.id === addressId);
        if (address) {
            document.getElementById('addressModal').classList.remove('hidden');
            document.getElementById('modalTitle').textContent = 'Edit Address';

            // Fill the form
            document.querySelector('select[name="address_type"]').value = address.address_type;
            document.getElementById('full_name').value = address.full_name;
            document.getElementById('phone').value = address.phone;
            document.getElementById('address_line1').value = address.address_line1;
            document.getElementById('address_line2').value = address.address_line2 || '';
            document.getElementById('landmark').value = address.landmark || '';
            document.getElementById('city').value = address.city;
            document.getElementById('state').value = address.state;
            document.getElementById('pincode').value = address.pincode;
            document.getElementById('country').value = address.country;
            document.getElementById('is_default').checked = address.is_default == 1;
        }
    }

    function setDefaultAddress(addressId) {
        Swal.fire({
            title: 'Set as Default?',
            text: 'This address will be used as your default shipping address.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Set Default',
            cancelButtonText: 'Cancel',
            background: '#000000',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Default address has been updated.',
                    icon: 'success',
                    confirmButtonColor: '#ffffff',
                    background: '#000000',
                    color: '#ffffff'
                });
            }
        });
    }

    function deleteAddress(addressId) {
        Swal.fire({
            title: 'Delete Address?',
            text: 'Are you sure you want to delete this address? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            background: '#000000',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Address has been deleted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#ffffff',
                    background: '#000000',
                    color: '#ffffff'
                });
            }
        });
    }

    // Order Functions
    function switchToOrdersTab() {
        document.querySelector('a[href="#orders"]').click();
    }

    function viewOrderDetails(orderId) {
        // Static order details content
        const orderDetails = `
            <div class="order-details-content text-white">
                <div class="order-header mb-6">
                    <h4 class="text-lg font-semibold">Order #${orderId}</h4>
                    <p class="text-gray-300">Placed on March 15, 2024 at 2:30 PM</p>
                </div>
                
                <div class="order-items mb-6">
                    <h5 class="font-semibold mb-3">Order Items</h5>
                    <div class="space-y-3">
                        <div class="item flex justify-between border-b border-gray-700 pb-3">
                            <span>Women's Summer Dress (Size: M)</span>
                            <span>₹2,499.00</span>
                        </div>
                        <div class="item flex justify-between border-b border-gray-700 pb-3">
                            <span>Men's Casual Shirt (Size: L)</span>
                            <span>₹1,799.00</span>
                        </div>
                        <div class="item flex justify-between">
                            <span>Kids T-shirt (Size: S)</span>
                            <span>₹599.00</span>
                        </div>
                    </div>
                </div>
                
                <div class="order-summary bg-gray-900 p-4 rounded-lg">
                    <div class="flex justify-between font-semibold text-lg">
                        <span>Total Amount:</span>
                        <span>₹4,897.00</span>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('orderDetailsContent').innerHTML = orderDetails;
        document.getElementById('orderDetailsModal').classList.remove('hidden');
    }

    function closeOrderDetailsModal() {
        document.getElementById('orderDetailsModal').classList.add('hidden');
    }

    // Form validation and other functions
    document.addEventListener('DOMContentLoaded', function () {
        const addressForm = document.getElementById('addressForm');
        if (addressForm) {
            addressForm.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Success!',
                    text: 'Address has been saved successfully.',
                    icon: 'success',
                    confirmButtonColor: '#ffffff',
                    background: '#000000',
                    color: '#ffffff'
                }).then(() => {
                    closeAddressModal();
                });
            });
        }

        // Tab switching functionality
        const navItems = document.querySelectorAll('.nav-item');
        const tabContents = document.querySelectorAll('.tab-content');

        navItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();

                // Remove active class from all items and contents
                navItems.forEach(nav => {
                    nav.classList.remove('bg-white', 'text-black');
                    nav.classList.add('text-white', 'hover:bg-gray-800');
                });
                tabContents.forEach(content => content.classList.add('hidden'));

                // Add active class to clicked item
                this.classList.remove('text-white', 'hover:bg-gray-800');
                this.classList.add('bg-white', 'text-black');

                // Show corresponding tab content
                const tabId = this.getAttribute('href').substring(1);
                const tabContent = document.getElementById(tabId);
                if (tabContent) {
                    tabContent.classList.remove('hidden');
                    tabContent.classList.add('active');
                }
            });
        });

        // Phone number validation - only numbers
        const phoneInputs = document.querySelectorAll('input[type="tel"]');
        phoneInputs.forEach(input => {
            input.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });

        // Pincode validation - only numbers
        const pincodeInputs = document.querySelectorAll('input[name="pincode"]');
        pincodeInputs.forEach(input => {
            input.addEventListener('input', function (e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    });

    function confirmLogout() {
        Swal.fire({
            title: 'Logout?',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Logout',
            cancelButtonText: 'Cancel',
            background: '#000000',
            color: '#ffffff'
        });
        return false;
    }

    function resetForm() {
        Swal.fire({
            title: 'Reset Form?',
            text: 'This will reset all changes you made.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffffff',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Reset',
            cancelButtonText: 'Cancel',
            background: '#000000',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>