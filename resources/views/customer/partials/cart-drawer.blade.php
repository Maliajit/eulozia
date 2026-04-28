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
                <h2 class="text-xl font-bold text-secondary">Shopping Cart (0)</h2>
                <button id="closeCart" class="text-secondary hover:text-accent transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- SCROLLABLE CART CONTENT -->
        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-6">
            <p class="text-secondary text-center py-8">Your cart is empty.</p>
        </div>

        <!-- ORDER SUMMARY (Fixed Bottom) -->
        <div class="border-t border-gray-700 p-4 bg-gray-900 flex-shrink-0 sticky bottom-0 z-10">
            <h4 class="text-secondary font-semibold mb-3">Order Summary</h4>
            <div class="flex justify-between items-center mb-4 py-2 border-t border-gray-700">
                <span class="text-secondary font-bold text-lg">Total Payable</span>
                <span class="text-secondary font-bold text-lg">₹0</span>
            </div>
            @auth('customer')
                <a href="{{ route('customer.checkout.index') }}" id="checkoutLink">
                    <button id="checkoutBtn"
                        class="w-full bg-accent text-primary py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition mb-3 disabled:opacity-50 disabled:cursor-not-allowed">
                        PROCEED TO BUY
                    </button>
                </a>
            @else
                <button id="checkoutBtn" onclick="handleUnauthenticatedCheckout()"
                    class="w-full bg-accent text-primary py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition mb-3 disabled:opacity-50 disabled:cursor-not-allowed">
                    PROCEED TO BUY
                </button>
            @endauth
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-sm bg-primary border border-gray-800 rounded-2xl p-6 shadow-2xl">
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-red-500 bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-secondary mb-2">Remove Item?</h3>
            <p class="text-gray-400 mb-6">Are you sure you want to remove this item from your cart?</p>
            <div class="flex space-x-3 w-full">
                <button id="cancelConfirm" class="flex-1 px-4 py-3 bg-gray-800 text-secondary rounded-xl font-semibold hover:bg-gray-700 transition duration-300">
                    Cancel
                </button>
                <button id="confirmRemove" class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition duration-300">
                    Remove
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    async function openCart() {
        const modal = document.getElementById('cartModal');
        const drawer = modal.querySelector('.transform');

        // Fetch and render initial data
        await fetchCart();

        modal.classList.remove('hidden');
        setTimeout(() => drawer.classList.remove('translate-x-full'), 10);
        document.body.style.overflow = 'hidden';
    }

    async function fetchCart() {
        try {
            const response = await axios.get("{{ route('customer.cart.summary') }}");
            if (response.data.success) {
                renderCart(response.data.data);
            }
        } catch (error) {
            console.error('Error fetching cart:', error);
        }
    }

    function renderCart(cart) {
        const contentContainer = document.querySelector('#cartModal .overflow-y-auto');
        const countHeader = document.querySelector('#cartModal h2');
        const totalDisplay = document.querySelector('#cartModal .justify-between .text-lg:last-child');

        if (!contentContainer || !cart) return;

        // Update Header Count
        if (countHeader) countHeader.textContent = `Shopping Cart (${cart.items_count || 0})`;

        // Update Total
        if (totalDisplay) totalDisplay.textContent = `₹${(cart.grand_total || 0).toLocaleString('en-IN')}`;

        // Update Global Header Count Badge
        updateGlobalCount(cart.items_count || 0);

        if (!cart.items || cart.items.length === 0) {
            contentContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-secondary text-lg font-semibold mb-2">Your cart is empty</h3>
                    <p class="text-gray-400 text-sm mb-8">Looks like you haven't added anything to your cart yet.</p>
                    <button onclick="closeCart()" class="bg-accent text-primary py-3 px-8 rounded-lg font-bold hover:bg-gray-300 transition duration-300">
                        SHOP NOW
                    </button>
                </div>
            `;
            // Disable checkout button
            const checkoutBtn = document.getElementById('checkoutBtn');
            if (checkoutBtn) {
                checkoutBtn.disabled = true;
                checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            const checkoutLink = document.getElementById('checkoutLink');
            if (checkoutLink) {
                checkoutLink.style.pointerEvents = 'none';
            }
            return;
        }

        // Enable checkout button
        const checkoutBtn = document.getElementById('checkoutBtn');
        if (checkoutBtn) {
            checkoutBtn.disabled = false;
            checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        }
        const checkoutLink = document.getElementById('checkoutLink');
        if (checkoutLink) {
            checkoutLink.style.pointerEvents = 'auto';
        }

        let html = '<div class="space-y-4">';
        cart.items.forEach(item => {
            let attributesHtml = '';
            if (item.attributes && Object.keys(item.attributes).length > 0) {
                attributesHtml = '<div class="text-xs text-secondary opacity-70 mt-1">';
                for (const [key, value] of Object.entries(item.attributes)) {
                    attributesHtml += `<span class="mr-2 capitalize">${key}: ${value}</span>`;
                }
                attributesHtml += '</div>';
            }

            html += `
                <div class="flex gap-4 border-b border-gray-800 pb-4 last:border-0" data-item-id="${item.id}">
                    <div class="w-20 h-20 flex-shrink-0 bg-gray-800 rounded overflow-hidden">
                        <img src="${item.image || '/images/placeholder-product.jpg'}" alt="${item.product_name}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-secondary font-medium truncate">${item.product_name}</h4>
                        <p class="text-accent text-sm">${item.sku || ''}</p>
                        ${attributesHtml}
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center space-x-2">
                                <button onclick="updateCartItem('${item.id}', ${item.quantity - 1})" class="text-accent hover:text-secondary disabled:opacity-50" ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
                                <span class="text-secondary text-sm">${item.quantity}</span>
                                <button onclick="updateCartItem('${item.id}', ${item.quantity + 1})" class="text-accent hover:text-secondary">+</button>
                            </div>
                            <span class="text-secondary font-semibold">₹${(item.total).toLocaleString('en-IN')}</span>
                        </div>
                    </div>
                    <button onclick="removeFromCart('${item.id}')" class="text-gray-500 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>
                </div>
            `;
        });
        html += '</div>';
        contentContainer.innerHTML = html;
    }

    async function updateCartItem(itemId, quantity) {
        if (quantity < 1) return;
        try {
            const response = await axios.put(`${baseUrl}/cart/update/${itemId}`, { quantity });
            if (response.data.success) {
                renderCart(response.data.data.cart);
                updateGlobalCount(response.data.data.cart_count);
            }
        } catch (error) {
            alert(error.response?.data?.message || 'Failed to update quantity');
        }
    }

    let itemToRemove = null;

    function removeFromCart(itemId) {
        itemToRemove = itemId;
        const confirmModal = document.getElementById('confirmModal');
        confirmModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    document.getElementById('cancelConfirm').addEventListener('click', () => {
        document.getElementById('confirmModal').classList.add('hidden');
        if (!document.getElementById('cartModal').classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
        itemToRemove = null;
    });

    document.getElementById('confirmRemove').addEventListener('click', async () => {
        if (!itemToRemove) return;
        
        try {
            const response = await axios.delete(`${baseUrl}/cart/remove/${itemToRemove}`);
            if (response.data.success) {
                renderCart(response.data.data.cart);
                updateGlobalCount(response.data.data.cart_count);
            }
        } catch (error) {
            console.error('Failed to remove item:', error);
            if (typeof showToast === 'function') {
                showToast('Failed to remove item', 'error');
            }
        } finally {
            document.getElementById('confirmModal').classList.add('hidden');
            itemToRemove = null;
            if (document.getElementById('cartModal').classList.contains('hidden')) {
                document.body.style.overflow = 'auto';
            }
        }
    });

    async function removeFromCartLegacy(itemId) {
        if (!confirm('Remove this item from cart?')) return;
        try {
            const response = await axios.delete(`${baseUrl}/cart/remove/${itemId}`);
            if (response.data.success) {
                renderCart(response.data.data.cart);
                updateGlobalCount(response.data.data.cart_count);
            }
        } catch (error) {
            alert('Failed to remove item');
        }
    }

    function updateGlobalCount(count) {
        const countBadge = document.getElementById('cart-count-badge');
        if (countBadge) countBadge.textContent = count;
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

    function handleUnauthenticatedCheckout() {
        if (typeof showToast === 'function') {
            showToast('Please login to proceed with your purchase', 'info', 3000);
        } else {
            alert('Please login to proceed with your purchase');
        }

        // Open login modal after a short delay
        setTimeout(() => {
            if (typeof openLoginModal === 'function') {
                openLoginModal();
            } else {
                window.location.href = "{{ route('customer.login') }}";
            }
        }, 1000);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const backdrop = document.getElementById('cartBackdrop');
        const closeBtn = document.getElementById('closeCart');
        if (backdrop) backdrop.addEventListener('click', closeCart);
        if (closeBtn) closeBtn.addEventListener('click', closeCart);
        document.addEventListener('keydown', e => e.key === 'Escape' && closeCart());
    });
    window.openCart = openCart;
</script>

<style>
    .transform {
        transition: transform 0.3s ease-in-out;
    }
</style>