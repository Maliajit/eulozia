<!-- Cart Modal -->
<div class="fixed inset-0 z-50 hidden" id="cartModal">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50" id="cartBackdrop"></div>

    <!-- Drawer -->
    <div class="absolute right-0 top-0 h-full w-full max-w-md bg-primary shadow-xl transform transition-transform duration-300 translate-x-full flex flex-col">
        <!-- HEADER (Fixed Top) -->
        <div class="border-b border-gray-700 p-4 flex-shrink-0 bg-primary sticky top-0 z-10">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-secondary">Shopping Cart (0)</h2>
                <button id="closeCart" class="text-secondary hover:text-accent transition-colors duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-2 bg-red-600 text-secondary text-sm py-1 px-3 rounded-full inline-block">
                Sale ends in: <span class="font-bold">02h 30m 47s</span>
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
            <a href="{{ route('checkout.index') }}">
                <button class="w-full bg-accent text-primary py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition mb-3">
                    PROCEED TO BUY
                </button>
            </a>
        </div>
    </div>
</div>

<script>
    function openCart() {
        const modal = document.getElementById('cartModal');
        const drawer = modal.querySelector('.transform');
        modal.classList.remove('hidden');
        setTimeout(() => drawer.classList.remove('translate-x-full'), 10);
        document.body.style.overflow = 'hidden';
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

    document.addEventListener('DOMContentLoaded', () => {
        const backdrop = document.getElementById('cartBackdrop');
        const closeBtn = document.getElementById('closeCart');
        if(backdrop) backdrop.addEventListener('click', closeCart);
        if(closeBtn) closeBtn.addEventListener('click', closeCart);
        document.addEventListener('keydown', e => e.key === 'Escape' && closeCart());
    });
    window.openCart = openCart;
</script>

<style>
    .transform { transition: transform 0.3s ease-in-out; }
</style>
