@extends('customer.layouts.master')

@section('title', 'Verify Account - Eulozia')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 bg-primary">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-gray-900 border border-gray-800 rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-10 text-center border-b border-gray-800">
                <div class="w-20 h-20 bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-accent">
                    <i class="fas fa-user-check text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-secondary mb-3">Verify Your Account</h1>
                <p class="text-accent leading-relaxed">We've sent a 6-digit OTP to your email <span class="text-secondary font-bold">{{ session('email') }}</span></p>
            </div>

            <div class="p-10">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-xl mb-8 text-sm text-center font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-xl mb-8 text-sm text-center font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Verification Form -->
                <form method="POST" action="{{ route('customer.verify.submit') }}" class="space-y-8">
                    @csrf
                    <div>
                        <label for="email_otp" class="block text-sm font-medium text-secondary mb-3">Enter OTP Code</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="text" id="email_otp" name="email_otp" maxlength="6"
                                   class="w-full bg-gray-800 border-gray-700 text-secondary pl-12 pr-4 py-4 rounded-xl text-center text-2xl font-bold tracking-[0.5em] focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-300 @error('email_otp') border-red-500 @enderror"
                                   placeholder="000000" required focus autocomplete="one-time-code">
                        </div>
                        @error('email_otp')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full bg-accent text-primary py-4 px-6 rounded-xl font-bold hover:bg-white hover:scale-[1.02] active:scale-95 transition-all duration-300 shadow-lg uppercase tracking-wider">
                        Verify Account
                    </button>
                </form>

                <!-- Resend & Support -->
                <div class="mt-10 text-center space-y-4">
                    <p class="text-accent text-sm">
                        Didn't receive the code? 
                        <button type="button" id="resendBtn" class="text-secondary font-bold hover:text-accent transition-colors ml-1 disabled:opacity-50">
                            Resend Code
                        </button>
                    </p>
                    <a href="{{ route('customer.register') }}" class="block text-xs text-gray-500 hover:text-secondary transition-colors">Entered wrong email? Register again.</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resendBtn = document.getElementById('resendBtn');
    if (!resendBtn) return;

    resendBtn.addEventListener('click', async function() {
        try {
            resendBtn.disabled = true;
            resendBtn.textContent = 'Sending...';
            
            const response = await axios.post("{{ route('customer.otp.resend') }}");
            
            if (response.data.success) {
                showToast(response.data.message || 'OTP resent successfully!', 'success');
                
                // Countdown for resend
                let countdown = 60;
                const timer = setInterval(() => {
                    countdown--;
                    if (countdown <= 0) {
                        clearInterval(timer);
                        resendBtn.disabled = false;
                        resendBtn.textContent = 'Resend Code';
                    } else {
                        resendBtn.textContent = `Resend in ${countdown}s`;
                    }
                }, 1000);
            } else {
                showToast(response.data.message || 'Failed to resend OTP', 'error');
                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend Code';
            }
        } catch (error) {
            console.error('Resend Error:', error);
            showToast(error.response?.data?.message || 'Something went wrong', 'error');
            resendBtn.disabled = false;
            resendBtn.textContent = 'Resend Code';
        }
    });
});
</script>
@endsection
