<!-- Signup Modal -->
<div id="signupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-primary rounded-lg max-w-md w-full mx-auto transform transition-all duration-300 scale-95 opacity-0" id="signupModalContent">
        <div class="border-b border-gray-700 p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold text-secondary">Create Your Account</h3>
            <button id="closeSignupModal" class="text-secondary hover:text-accent transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="p-6">
            <form id="signupForm" method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="signupName" class="block text-sm font-medium text-secondary mb-2">Full Name</label>
                    <input type="text" id="signupName" name="name" class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent" required>
                </div>
                <div>
                    <label for="signupEmail" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                    <input type="email" id="signupEmail" name="email" class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent" required>
                </div>
                <div>
                    <label for="signupPassword" class="block text-sm font-medium text-secondary mb-2">Password</label>
                    <input type="password" id="signupPassword" name="password" class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent" required>
                </div>
                <div>
                    <label for="signupPassword_confirmation" class="block text-sm font-medium text-secondary mb-2">Confirm Password</label>
                    <input type="password" id="signupPassword_confirmation" name="password_confirmation" class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent" required>
                </div>
                <button type="submit" class="w-full bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition">
                    Create Account
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-accent">
                    Already have an account? 
                    <button onclick="closeSignupModal(); openLoginModal();" class="text-secondary font-semibold hover:text-accent">
                        Login here
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function openSignupModal() {
        const modal = document.getElementById('signupModal');
        const content = document.getElementById('signupModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeSignupModal() {
        const modal = document.getElementById('signupModal');
        const content = document.getElementById('signupModalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const closeBtn = document.getElementById('closeSignupModal');
        if(closeBtn) closeBtn.addEventListener('click', closeSignupModal);
    });
    window.openSignupModal = openSignupModal;
    window.closeSignupModal = closeSignupModal;
</script>
