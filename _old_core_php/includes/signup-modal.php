<?php
// includes/signup-modal.php
?>
<!-- Signup Modal -->
<div id="signupModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-primary rounded-lg max-w-md w-full mx-auto transform transition-all duration-300 scale-95 opacity-0"
         id="signupModalContent">
        <!-- Modal Header -->
        <div class="border-b border-gray-700 p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold text-secondary">Create Your Account</h3>
            <button id="closeSignupModal" class="text-secondary hover:text-accent transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <!-- Social Signup Buttons -->
            <div class="grid grid-cols-2 gap-3 mb-6">
                <button class="flex items-center justify-center gap-2 bg-gray-800 text-secondary py-3 px-4 rounded hover:bg-gray-700 transition-colors duration-300">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Google
                </button>
                <button class="flex items-center justify-center gap-2 bg-gray-800 text-secondary py-3 px-4 rounded hover:bg-gray-700 transition-colors duration-300">
                    <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
            </div>

            <!-- Divider -->
            <div class="relative mb-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-primary text-accent">Or sign up with email</span>
                </div>
            </div>

            <!-- Signup Form -->
            <form id="signupForm" class="space-y-4">
                <div>
                    <label for="signupName" class="block text-sm font-medium text-secondary mb-2">Full Name</label>
                    <input type="text" id="signupName" name="name" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Enter your full name" required>
                </div>

                <div>
                    <label for="signupEmail" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                    <input type="email" id="signupEmail" name="email" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Enter your email" required>
                </div>

                <div>
                    <label for="signupPhone" class="block text-sm font-medium text-secondary mb-2">Phone Number</label>
                    <input type="tel" id="signupPhone" name="phone" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Enter your phone number">
                </div>

                <div>
                    <label for="signupPassword" class="block text-sm font-medium text-secondary mb-2">Password</label>
                    <input type="password" id="signupPassword" name="password" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Create a password" required>
                    <div class="mt-1 text-xs text-accent" id="passwordStrength"></div>
                </div>

                <div>
                    <label for="signupConfirmPassword" class="block text-sm font-medium text-secondary mb-2">Confirm Password</label>
                    <input type="password" id="signupConfirmPassword" name="confirmPassword" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Confirm your password" required>
                </div>

                <label class="flex items-start space-x-3">
                    <input type="checkbox" class="mt-1 rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent" required>
                    <span class="text-sm text-accent">
                        I agree to the <a href="#" class="text-secondary hover:text-accent transition-colors duration-300">Terms & Conditions</a> 
                        and <a href="#" class="text-secondary hover:text-accent transition-colors duration-300">Privacy Policy</a>
                    </span>
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
                    <button id="showLoginModal" class="text-secondary font-semibold hover:text-accent transition-colors duration-300">
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

// Initialize signup modal
document.addEventListener('DOMContentLoaded', function() {
    const signupModal = document.getElementById('signupModal');
    if (!signupModal) return;

    // Close modal events
    document.getElementById('closeSignupModal')?.addEventListener('click', closeSignupModal);
    signupModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeSignupModal();
        }
    });

    // Switch to login modal
    document.getElementById('showLoginModal')?.addEventListener('click', function() {
        closeSignupModal();
        setTimeout(() => {
            if (typeof openLoginModal === 'function') {
                openLoginModal();
            }
        }, 350);
    });

    // Signup form submission
    document.getElementById('signupForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your signup logic here
        console.log('Signup form submitted');
        // Close modal after successful signup
        closeSignupModal();
    });

    // Password strength indicator
    const passwordInput = document.getElementById('signupPassword');
    const strengthText = document.getElementById('passwordStrength');
    
    if (passwordInput && strengthText) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 'Weak';
            let color = 'text-red-500';
            
            if (password.length >= 8) {
                strength = 'Medium';
                color = 'text-yellow-500';
            }
            if (password.length >= 12 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                strength = 'Strong';
                color = 'text-green-500';
            }
            
            strengthText.textContent = `Password strength: ${strength}`;
            strengthText.className = `mt-1 text-xs ${color}`;
        });
    }

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !signupModal.classList.contains('hidden')) {
            closeSignupModal();
        }
    });
});

// Make openSignupModal globally available
window.openSignupModal = openSignupModal;
</script>

<style>
/* Smooth transitions for the modal */
#signupModalContent {
    transition: all 0.3s ease-in-out;
}
</style>