<!-- Logout Confirmation Modal -->
<div id="logoutModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] hidden flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl max-w-sm w-full p-8 shadow-2xl transform transition-all animate-fadeIn">
        <div class="text-center">
            <div class="w-20 h-20 bg-rose-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">Confirm Logout</h3>
            <p class="text-gray-400 mb-8">Are you sure you want to log out of your account?</p>
            
            <div class="flex gap-4">
                <button onclick="closeLogoutModal()" class="flex-1 px-6 py-3.5 rounded-xl text-white hover:bg-gray-800 font-bold transition-all border border-gray-800">
                    Cancel
                </button>
                <button onclick="executeLogout()" class="flex-1 px-6 py-3.5 rounded-xl bg-rose-500 text-white font-bold hover:bg-rose-600 shadow-lg shadow-rose-500/20 transition-all">
                    Logout
                </button>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('customer.logout') }}" id="global-logout-form" class="hidden">
    @csrf
</form>

<script>
    function confirmLogout() {
        const modal = document.getElementById('logoutModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            if (confirm('Are you sure you want to logout?')) {
                const form = document.getElementById('global-logout-form') || document.getElementById('logout-form');
                if (form) form.submit();
            }
        }
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function executeLogout() {
        const form = document.getElementById('global-logout-form') || document.getElementById('logout-form');
        if (form) form.submit();
    }
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out forwards;
}
</style>
