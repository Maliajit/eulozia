@extends('customer.layouts.master')

@section('title', 'Secure Payment - Razorpay')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-50 rounded-full mb-6">
                    <i class="fas fa-shield-alt text-3xl text-indigo-600 animate-pulse"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Secure Payment</h2>
                <p class="mt-4 text-gray-600">Please wait while we redirect you to the secure payment gateway...</p>
            </div>

            <div class="mt-8 border-t border-b border-gray-100 py-6 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Order Number</span>
                    <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Total Amount</span>
                    <span class="font-bold text-indigo-600 text-lg">₹{{ number_format($amount, 2) }}</span>
                </div>
            </div>

            <div class="mt-8 flex flex-col space-y-4">
                <button id="rzp-button"
                    class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                    Pay Now
                </button>
                <p class="text-xs text-center text-gray-400">
                    You will be redirected to Razorpay's secure payment portal.
                </p>
            </div>

            <div class="mt-6 flex justify-center items-center space-x-2 grayscale opacity-50">
                <img src="https://razorpay.com/assets/razorpay-glyph.svg" class="h-5" alt="Razorpay">
                <span class="text-[10px] font-medium tracking-widest uppercase">Verified Secure</span>
            </div>
        </div>
    </div>

    <form action="{{ route('customer.checkout.payment.callback') }}" method="POST" id="razorpay-form"
        style="display: none;">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="{{ $orderId }}">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>

@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const options = {
            "key": "{{ $keyId }}",
            "amount": "{{ $amount * 100 }}",
            "currency": "INR",
            "name": "{{ config('app.name') }}",
            "description": "Payment for Order #{{ $order->order_number }}",
            "order_id": "{{ $orderId }}",
            "handler": function (response) {
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.getElementById('razorpay-form').submit();
            },
            "prefill": {
                "name": "{{ $customer->name ?? '' }}",
                "email": "{{ $customer->email ?? '' }}",
                "contact": "{{ $customer->mobile ?? '' }}"
            },
            "theme": {
                "color": "#4f46e5"
            },
            "modal": {
                "ondismiss": function () {
                    // Re-enable button if modal closed
                    const btn = document.getElementById('rzp-button');
                    btn.innerHTML = 'Pay Now';
                    btn.disabled = false;
                }
            }
        };

        const rzp = new Razorpay(options);

        document.getElementById('rzp-button').onclick = function (e) {
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Initializing...';
            this.disabled = true;
            rzp.open();
            e.preventDefault();
        }

        // Auto-open on load
        window.onload = function () {
            setTimeout(() => {
                document.getElementById('rzp-button').click();
            }, 1000);
        };
    </script>
@endpush