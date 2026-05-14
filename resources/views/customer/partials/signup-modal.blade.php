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
            <div id="signupFormContainer">
                <form id="signupForm" class="space-y-4">
                    @csrf
                    <div id="signupInitialStep">
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
                            <input type="tel" id="signupPhone" name="mobile"
                                class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent"
                                placeholder="Enter 10-digit mobile number"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);" pattern="[0-9]{10}"
                                maxlength="10" minlength="10" inputmode="numeric" required>
                        </div>

                        <label class="flex items-start space-x-3 mt-4">
                            <input type="checkbox" name="terms"
                                class="mt-1 rounded bg-gray-800 border-gray-700 text-accent focus:ring-accent"
                                required>
                            <span class="text-sm text-accent">
                                I agree to the <a href="#" class="text-secondary hover:text-accent transition-colors duration-300">Terms & Conditions</a>
                            </span>
                        </label>

                        <button type="button" id="sendSignupOtpBtn"
                            class="w-full mt-6 bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition-colors duration-300 flex items-center justify-center">
                            <span>Continue</span>
                        </button>
                    </div>

                    <div id="signupOtpStep" class="hidden animate-fade-in">
                        <div class="mb-4 text-center">
                            <p class="text-sm text-accent mb-2">Verification code sent to your email.</p>
                            <label for="signupOtp" class="block text-sm font-medium text-secondary mb-2">Enter OTP</label>
                            <input type="text" id="signupOtp" name="otp" maxlength="6"
                                class="w-full bg-gray-800 text-secondary px-4 py-3 rounded focus:outline-none focus:ring-2 focus:ring-accent text-center text-2xl tracking-widest"
                                placeholder="000000">
                        </div>
                        <button type="submit" id="verifySignupOtpBtn"
                            class="w-full bg-accent text-primary py-3 px-6 rounded font-semibold hover:bg-gray-300 transition-colors duration-300 flex items-center justify-center">
                            <span>Create Account</span>
                        </button>
                        <button type="button" id="resendSignupOtpBtn" class="w-full mt-4 text-sm text-accent hover:text-secondary transition-colors duration-300">
                            Resend OTP
                        </button>
                    </div>
                </form>
            </div>

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
            resetSignupForm();
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

    function resetSignupForm() {
        document.getElementById('signupInitialStep').classList.remove('hidden');
        document.getElementById('signupOtpStep').classList.add('hidden');
        document.getElementById('signupForm').reset();
    }

    // Initialize signup modal
    document.addEventListener('DOMContentLoaded', function () {
        const signupModal = document.getElementById('signupModal');
        if (!signupModal) return;

        const sendOtpBtn = document.getElementById('sendSignupOtpBtn');
        const verifyOtpBtn = document.getElementById('verifySignupOtpBtn');
        const signupForm = document.getElementById('signupForm');
        
        const nameInput = document.getElementById('signupName');
        const emailInput = document.getElementById('signupEmail');
        const phoneInput = document.getElementById('signupPhone');
        const otpInput = document.getElementById('signupOtp');
        const resendBtn = document.getElementById('resendSignupOtpBtn');

        const initialStep = document.getElementById('signupInitialStep');
        const otpStep = document.getElementById('signupOtpStep');

        // Close modal events
        document.getElementById('closeSignupModal')?.addEventListener('click', closeSignupModal);
        signupModal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeSignupModal();
            }
        });

        // Send OTP Logic
        sendOtpBtn?.addEventListener('click', async function() {
            const email = emailInput.value;
            const name = nameInput.value;
            const mobile = phoneInput.value;
            const terms = document.querySelector('input[name="terms"]').checked;

            if (!name || !email || !mobile || !terms) {
                showToast('Please fill all fields and agree to terms', 'error');
                return;
            }

            if (!email.includes('@')) {
                showToast('Please enter a valid email address', 'error');
                return;
            }

            if (mobile.length !== 10) {
                showToast('Please enter a valid 10-digit mobile number', 'error');
                return;
            }

            setLoading(this, true);
            try {
                const response = await axios.post("{{ route('customer.otp.send') }}", {
                    email: email,
                    type: 'register'
                });

                if (response.data.success) {
                    showToast(response.data.message, 'success');
                    initialStep.classList.add('hidden');
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

        // Verify OTP & Register Logic
        signupForm?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const name = nameInput.value;
            const email = emailInput.value;
            const mobile = phoneInput.value;
            const otp = otpInput.value;

            if (!otp || otp.length !== 6) {
                showToast('Please enter a valid 6-digit OTP', 'error');
                return;
            }

            const btn = document.getElementById('verifySignupOtpBtn');
            setLoading(btn, true);

            try {
                const response = await axios.post("{{ route('customer.otp.verify') }}", {
                    name: name,
                    email: email,
                    mobile: mobile,
                    otp: otp,
                    type: 'register'
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
                setLoading(btn, false, 'Create Account');
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

        // Close with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !signupModal.classList.contains('hidden')) {
                closeSignupModal();
            }
        });
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