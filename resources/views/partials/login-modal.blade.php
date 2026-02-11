<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-primary rounded-lg max-w-md w-full mx-auto transform transition-all duration-300 scale-95 opacity-0" id="loginModalContent">
        <div class="border-b border-gray-700 p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold text-secondary">Login to Your Account</h3>
            <button id="closeLoginModal" class="text-secondary hover:text-accent transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-2 gap-3 mb-6">
                <button class="flex items-center justify-center gap-2 bg-gray-800 text-secondary py-3 px-4 rounded hover:bg-gray-700 transition">
                    Google
                </button>
                <button class="flex items-center justify-center gap-2 bg-gray-800 text-secondary py-3 px-4 rounded hover:bg-gray-700 transition">
                    Facebook
                </button>
            </div>

            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-primary text-accent">Or continue with email</span>
                </div>
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="loginEmail" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                    <input type="email" id="loginEmail" name="email" class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent" required>
                </div>
                <div>
                    <label for="loginPassword" class="block text-sm font-medium text-secondary mb-2">Password</label>
                    <input type="password" id="loginPassword" name="password" class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent" required>
                </div>
                <button type="submit" class="w-full bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-accent">
                    New to our store? 
                    <button onclick="closeLoginModal(); openSignupModal();" class="text-secondary font-semibold hover:text-accent">
                        Create an account
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function openLoginModal() {
        const modal = document.getElementById('loginModal');
        const content = document.getElementById('loginModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        const content = document.getElementById('loginModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const closeBtn = document.getElementById('closeLoginModal');
        if(closeBtn) closeBtn.addEventListener('click', closeLoginModal);
    });
    window.openLoginModal = openLoginModal;
    window.closeLoginModal = closeLoginModal;
</script>
