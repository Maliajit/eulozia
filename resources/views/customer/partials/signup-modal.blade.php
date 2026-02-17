<!-- Signup Modal -->
<div id="signupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-primary rounded-lg max-w-md w-full mx-auto transform transition-all duration-300 scale-95 opacity-0"
        id="signupModalContent">
        <!-- Modal Header -->
        <div class="border-b border-gray-700 p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold text-secondary">Create Your Account</h3>
            <button id="closeSignupModal" class="text-secondary hover:text-accent transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">


            <!-- Signup Form -->
            <form id="signupForm" method="POST" action="{{ route('customer.register.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="signupName" class="block text-sm font-medium text-secondary mb-2">Full Name</label>
                    <input type="text" id="signupName" name="name"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('name') border-red-500 @enderror"
                        placeholder="Enter your full name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="signupEmail" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                    <input type="email" id="signupEmail" name="email"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('email') border-red-500 @enderror"
                        placeholder="Enter your email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="signupPhone" class="block text-sm font-medium text-secondary mb-2">Phone Number</label>
                    <input type="tel" id="signupPhone" name="mobile"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('mobile') border-red-500 @enderror"
                        placeholder="Enter 10-digit mobile number" value="{{ old('mobile') }}"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);" pattern="[0-9]{10}"
                        maxlength="10" minlength="10" inputmode="numeric" required>
                    @error('mobile')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="signupPassword" class="block text-sm font-medium text-secondary mb-2">Password</label>
                    <input type="password" id="signupPassword" name="password"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('password') border-red-500 @enderror"
                        placeholder="Create a password" required>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <div class="mt-1 text-xs text-accent" id="passwordStrength"></div>
                </div>

                <div>
                    <label for="signupConfirmPassword" class="block text-sm font-medium text-secondary mb-2">Confirm
                        Password</label>
                    <input type="password" id="signupConfirmPassword" name="password_confirmation"
                        class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent @error('password_confirmation') border-red-500 @enderror"
                        placeholder="Confirm your password" required>
                    @error('password_confirmation')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-start space-x-3">
                    <input type="checkbox" name="terms"
                        class="mt-1 rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent @error('terms') border-red-500 @enderror"
                        required>
                    <span class="text-sm text-accent">
                        I agree to the <a href="#"
                            class="text-secondary hover:text-accent transition-colors duration-300">Terms &
                            Conditions</a>
                        and <a href="#" class="text-secondary hover:text-accent transition-colors duration-300">Privacy
                            Policy</a>
                    </span>
                    @error('terms')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </label>

                <button type="submit"
                    class="w-full bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition-colors duration-300">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-accent">
                    Already have an account?
                    <button onclick="closeSignupModal(); openLoginModal();"
                        class="text-secondary font-semibold hover:text-accent transition-colors duration-300">
                        Login here
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Signup Modal Functionality
    function openSignupModal() {
        const modal = document.getElementById('signupModal');
        const content = document.getElementById('signupModalContent');

        if (modal && content) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);

            document.body.style.overflow = 'hidden';
        }
    }

    function closeSignupModal() {
        const modal = document.getElementById('signupModal');
        const content = document.getElementById('signupModalContent');

        if (modal && content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    // Initialize signup modal
    document.addEventListener('DOMContentLoaded', function () {
        const signupModal = document.getElementById('signupModal');
        if (!signupModal) return;

        // Close modal events
        document.getElementById('closeSignupModal')?.addEventListener('click', closeSignupModal);
        signupModal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeSignupModal();
            }
        });

        // Password strength indicator
        const passwordInput = document.getElementById('signupPassword');
        const strengthText = document.getElementById('passwordStrength');

        if (passwordInput && strengthText) {
            passwordInput.addEventListener('input', function () {
                const password = this.value;
                let strength = 'Too short';
                let color = 'text-red-500';

                if (password.length >= 6) {
                    strength = 'OK';
                    color = 'text-green-500';
                }

                strengthText.textContent = `Password status: ${strength}`;
                strengthText.className = `mt-1 text-xs ${color}`;
            });
        }


        // Close with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !signupModal.classList.contains('hidden')) {
                closeSignupModal();
            }
        });

        // Re-open if there were signup errors
        @if(session('form') === 'register' || ($errors->any() && session('form') === 'register'))         openSignupModal();         @if($errors->any())         if (typeof showToast === 'function') { showToast('{{ $errors->first() }}', 'error'); } @endif
        @endif
    });

    // Make openSignupModal globally available
    window.openSignupModal = openSignupModal;
    window.closeSignupModal = closeSignupModal;
</script>

<style>
    /* Smooth transitions for the modal */
    #signupModalContent {
        transition: all 0.3s ease-in-out;
    }
</style>