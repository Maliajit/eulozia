<?php
// includes/login-modal.php
?>
<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
    <div class="bg-primary rounded-lg max-w-md w-full mx-auto transform transition-all duration-300 scale-95 opacity-0"
         id="loginModalContent">
        <!-- Modal Header -->
        <div class="border-b border-gray-700 p-6 flex justify-between items-center">
            <h3 class="text-xl font-bold text-secondary">Login to Your Account</h3>
            <button id="closeLoginModal" class="text-secondary hover:text-accent transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <!-- Social Login Buttons -->
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
                    <span class="px-2 bg-primary text-accent">Or continue with email</span>
                </div>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="space-y-4">
                <div>
                    <label for="loginEmail" class="block text-sm font-medium text-secondary mb-2">Email or Phone</label>
                    <input type="text" id="loginEmail" name="email" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Enter your email or phone number" required>
                </div>
                
                <div>
                    <label for="loginPassword" class="block text-sm font-medium text-secondary mb-2">Password</label>
                    <input type="password" id="loginPassword" name="password" 
                           class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                           placeholder="Enter your password" required>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" class="rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent">
                        <span class="ml-2 text-sm text-accent">Remember me</span>
                    </label>
                    <button type="button" class="text-sm text-accent hover:text-secondary transition-colors duration-300">
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
                    <button id="showSignupModal" class="text-secondary font-semibold hover:text-accent transition-colors duration-300">
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

// Initialize login modal
document.addEventListener('DOMContentLoaded', function() {
    const loginModal = document.getElementById('loginModal');
    if (!loginModal) return;

    // Close modal events
    document.getElementById('closeLoginModal')?.addEventListener('click', closeLoginModal);
    loginModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeLoginModal();
        }
    });

    // Switch to signup modal
    document.getElementById('showSignupModal')?.addEventListener('click', function() {
        closeLoginModal();
        setTimeout(() => {
            if (typeof openSignupModal === 'function') {
                openSignupModal();
            }
        }, 350);
    });

    // Login form submission
    document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        // Add your login logic here
        console.log('Login form submitted');
        // Close modal after successful login
        closeLoginModal();
    });

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !loginModal.classList.contains('hidden')) {
            closeLoginModal();
        }
    });
});

// Make openLoginModal globally available
window.openLoginModal = openLoginModal;
</script>

<style>
/* Smooth transitions for the modal */
#loginModalContent {
    transition: all 0.3s ease-in-out;
}
</style>