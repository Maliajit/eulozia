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
            <div id="loginFormContainer">
                <form id="loginForm" class="space-y-4">
                    @csrf
                    <div id="loginEmailStep">
                        <label for="loginEmail" class="block text-sm font-medium text-secondary mb-2">Email Address</label>
                        <input type="email" id="loginEmail" name="email"
                            class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                            placeholder="Enter your email address" required>
                        <button type="button" id="sendLoginOtpBtn"
                            class="w-full mt-4 bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition-colors duration-300 flex items-center justify-center">
                            <span>Continue</span>
                        </button>
                    </div>

                    <div id="loginOtpStep" class="hidden animate-fade-in">
                        <div class="mb-4">
                            <p class="text-sm text-accent mb-2">We've sent a 6-digit OTP to your email.</p>
                            <label for="loginOtp" class="block text-sm font-medium text-secondary mb-2">Enter OTP</label>
                            <input type="text" id="loginOtp" name="otp" maxlength="6"
                                class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent text-center text-2xl tracking-widest"
                                placeholder="000000">
                        </div>
                        <button type="submit" id="verifyLoginOtpBtn"
                            class="w-full bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition-colors duration-300 flex items-center justify-center">
                            <span>Login</span>
                        </button>
                        <button type="button" id="resendLoginOtpBtn" class="w-full mt-4 text-sm text-accent hover:text-secondary transition-colors duration-300">
                            Resend OTP
                        </button>
                    </div>
                </form>
            </div>

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
            resetLoginForm();
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

    function resetLoginForm() {
        document.getElementById('loginEmailStep').classList.remove('hidden');
        document.getElementById('loginOtpStep').classList.add('hidden');
        document.getElementById('loginForm').reset();
    }

    // Initialize login modal
    document.addEventListener('DOMContentLoaded', function () {
        const loginModal = document.getElementById('loginModal');
        if (!loginModal) return;

        const sendOtpBtn = document.getElementById('sendLoginOtpBtn');
        const verifyOtpBtn = document.getElementById('verifyLoginOtpBtn');
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('loginEmail');
        const otpInput = document.getElementById('loginOtp');
        const resendBtn = document.getElementById('resendLoginOtpBtn');

        const emailStep = document.getElementById('loginEmailStep');
        const otpStep = document.getElementById('loginOtpStep');

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

        // Send OTP Logic
        sendOtpBtn?.addEventListener('click', async function() {
            const email = emailInput.value;
            if (!email || !email.includes('@')) {
                showToast('Please enter a valid email address', 'error');
                return;
            }

            setLoading(this, true);
            try {
                const response = await axios.post("{{ route('customer.otp.send') }}", {
                    email: email,
                    type: 'login'
                });

                if (response.data.success) {
                    showToast(response.data.message, 'success');
                    emailStep.classList.add('hidden');
                    otpStep.classList.remove('hidden');
                }
            } catch (error) {
                const message = error.response?.data?.message || 'Failed to send OTP';
                showToast(message, 'error');
            } finally {
                setLoading(this, false, 'Continue');
            }
        });

        // Resend OTP Logic
        resendBtn?.addEventListener('click', () => sendOtpBtn.click());

        // Verify OTP Logic
        loginForm?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const email = emailInput.value;
            const otp = otpInput.value;

            if (!otp || otp.length !== 6) {
                showToast('Please enter a valid 6-digit OTP', 'error');
                return;
            }

            const btn = document.getElementById('verifyLoginOtpBtn');
            setLoading(btn, true);

            try {
                const response = await axios.post("{{ route('customer.otp.verify') }}", {
                    email: email,
                    otp: otp,
                    type: 'login'
                });

                if (response.data.success) {
                    showToast(response.data.message, 'success');
                    setTimeout(() => {
                        window.location.href = response.data.redirect;
                    }, 1000);
                }
            } catch (error) {
                const message = error.response?.data?.message || 'Invalid OTP';
                showToast(message, 'error');
            } finally {
                setLoading(btn, false, 'Login');
            }
        });

        function setLoading(btn, isLoading, originalText = '') {
            if (isLoading) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            } else {
                btn.disabled = false;
                btn.innerHTML = `<span>${originalText}</span>`;
            }
        }
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