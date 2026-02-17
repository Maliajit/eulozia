<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-primary rounded-lg max-w-md w-full mx-auto transform transition-all duration-300 scale-95 opacity-0"
        id="loginModalContent">
        <!-- Modal Header -->
        <div class="border-b border-gray-700 p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold text-secondary">Login to Your Account</h3>
            <button id="closeLoginModal" class="text-secondary hover:text-accent transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">


            <!-- Login Form -->
            <form id="loginForm" method="POST" action="{{ route('customer.login.submit') }}" class="space-y-4">

                @csrf
                <div>
                    <label for="loginEmail" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                    <input type="email" id="loginEmail" name="email"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('email') border-red-500 @enderror"
                        placeholder="Enter your email address" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="loginPassword" class="block text-sm font-medium text-secondary mb-2">Password</label>
                    <input type="password" id="loginPassword" name="password"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('password') border-red-500 @enderror"
                        placeholder="Enter your password" required>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                        <span class="ml-2 text-sm text-accent">Remember me</span>
                    </label>
                    <button type="button"
                        class="text-sm text-accent hover:text-secondary transition-colors duration-300">
                        Forgot password?
                    </button>
                </div>

                <button type="submit"
                    class="w-full bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition-colors duration-300">
                    Login
                </button>
            </form>

            <!-- Signup Link -->
            <div class="mt-6 text-center">
                <p class="text-accent">
                    New to our store?
                    <button onclick="closeLoginModal(); openSignupModal();"
                        class="text-secondary font-semibold hover:text-accent transition-colors duration-300">
                        Create an account
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Login Modal Functionality
    function openLoginModal() {
        const modal = document.getElementById('loginModal');
        const content = document.getElementById('loginModalContent');

        if (modal && content) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        }
    }

    function closeLoginModal() {
        const modal = document.getElementById('loginModal');
        const content = document.getElementById('loginModalContent');

        if (modal && content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    // Initialize login modal
    document.addEventListener('DOMContentLoaded', function () {
        const loginModal = document.getElementById('loginModal');
        if (!loginModal) return;

        // Close modal events
        document.getElementById('closeLoginModal')?.addEventListener('click', closeLoginModal);
        loginModal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });

        // Close with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !loginModal.classList.contains('hidden')) {
                closeLoginModal();
            }
        });

        // Re-open if there were login errors
        @if(session('form') === 'login' || ($errors->any() && session('form') === 'login'))
            openLoginModal();
            @if($errors->any())
                if (typeof showToast === 'function') {
                    showToast('{{ $errors->first() }}', 'error');
                }
            @endif
        @endif
    });

    // Make openLoginModal globally available
    window.openLoginModal = openLoginModal;
    window.closeLoginModal = closeLoginModal;
</script>

<style>
    /* Smooth transitions for the modal */
    #loginModalContent {
        transition: all 0.3s ease-in-out;
    }
</style>