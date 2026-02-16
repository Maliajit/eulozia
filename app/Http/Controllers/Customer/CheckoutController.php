<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\Customer\CheckoutService;
use App\Services\Customer\RazorpayService;
use App\Services\Customer\DelhiveryService;
use App\Helpers\CartHelper;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        protected CheckoutService $checkoutService,
        protected CartHelper $cartHelper,
        protected RazorpayService $razorpayService,
        protected DelhiveryService $delhiveryService
    ) {
    }

    /* =====================================================
     | SHOW CHECKOUT
     ===================================================== */
    public function index()
    {
        $cart = $this->cartHelper->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('customer.home.index')
                ->with('error', 'Your cart is empty. Please add some products to proceed.');
        }

        return view('customer.checkout.index', [
            'cart' => $cart,
            'codAvailable' => $this->checkoutService->isCODAvailable(),
            'paymentMethods' => $this->checkoutService->getAvailablePaymentMethods(),
            'addresses' => Auth::guard('customer')->user()?->addresses ?? collect(),
        ]);
    }

    /* =====================================================
     | PROCESS CHECKOUT
     ===================================================== */
    public function processCheckout(Request $request)
    {
        if (session('checkout_in_progress')) {
            return response()->json(['success' => false, 'message' => 'An order is already being processed. Please wait.'], 429);
        }

        $this->validateCheckout($request);

        session(['checkout_in_progress' => true]);

        try {
            // Final check for Delhivery serviceability
            $pincode = $request->pincode;
            $serviceability = $this->delhiveryService->checkServiceability($pincode);

            if (!$serviceability['success']) {
                session()->forget('checkout_in_progress');
                return back()->with('error', $serviceability['message'])->withInput();
            }

            // Enforce shipping cost calculation
            $cart = $this->cartHelper->getCart();
            $shippingCost = $this->calculateShippingCost($cart);
            $request->merge(['shipping_cost' => $shippingCost]);

            if ($request->payment_method === 'cod') {
                $response = $this->processCOD($request);
                session()->forget('checkout_in_progress');
                return $response;
            }

            return $this->processOnlinePayment($request);
        } catch (\Exception $e) {
            session()->forget('checkout_in_progress');
            Log::error('Checkout processing failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }

    /* =====================================================
     | COD FLOW
     ===================================================== */
    private function processCOD(Request $request)
    {
        // Shipping cost is already merged in processCheckout
        $result = $this->checkoutService->placeOrder($request->all());

        if (!empty($result['order'])) {
            $this->delhiveryService->createOrder($result['order']);
        }

        return redirect()
            ->route('customer.checkout.confirmation', $result['order']->id)
            ->with('success', 'Order placed successfully!');
    }

    /* =====================================================
     | ONLINE PAYMENT INIT (NO DB ORDER)
     ===================================================== */
    private function processOnlinePayment(Request $request)
    {
        $cart = $this->cartHelper->getCart();

        // Ensure shipping cost is set in request data session
        // (It was merged in processCheckout, but good to be explicit)
        $shippingCost = $this->calculateShippingCost($cart);
        $data = $request->all();
        $data['shipping_cost'] = $shippingCost;

        session([
            'checkout_data' => $data
        ]);

        // Calculate correct total including shipping
        $grandTotal = $cart['subtotal'] + $cart['tax_total'] + $shippingCost - ($cart['discount_total'] ?? 0);

        $amountInPaise = (int) round($grandTotal * 100);

        $razorpayOrder = $this->razorpayService->createOrderByAmount($amountInPaise);

        if (!$razorpayOrder['success']) {
            return back()->with('error', $razorpayOrder['message']);
        }

        session([
            'razorpay_order_id' => $razorpayOrder['order_id']
        ]);

        return view('customer.checkout.payment', [
            'keyId' => $razorpayOrder['key_id'],
            'orderId' => $razorpayOrder['order_id'],
            'amount' => $grandTotal,
            'customer' => Auth::guard('customer')->user()
        ]);
    }

    /* =====================================================
     | RAZORPAY CALLBACK
     ===================================================== */
    public function paymentCallback(Request $request)
    {
        if (session('callback_in_progress')) {
            return response()->json(['status' => 'error', 'message' => 'Processing in progress'], 429);
        }

        session(['callback_in_progress' => true]);

        try {
            $razorpayOrderId = $request->razorpay_order_id;
            $paymentId = $request->razorpay_payment_id;
            $signature = $request->razorpay_signature;

            if (!$razorpayOrderId || !$paymentId || !$signature) {
                throw new \Exception('Missing payment details');
            }

            $verified = $this->razorpayService->verifyPayment($paymentId, $razorpayOrderId, $signature);

            if ($verified) {
                $checkoutData = session('checkout_data');
                if (!$checkoutData) {
                    throw new \Exception('Checkout session expired. Please contact support if your payment was deducted.');
                }

                $paymentData = [
                    'payment_id' => $paymentId,
                    'razorpay_order_id' => $razorpayOrderId,
                    'method' => 'online'
                ];

                $result = $this->checkoutService->placeOrder($checkoutData, $paymentData);

                if (!empty($result['order'])) {
                    // Try to create delhivery order
                    try {
                        $this->delhiveryService->createOrder($result['order']);
                    } catch (\Exception $e) {
                        Log::error('Delhivery order creation failed on callback', ['error' => $e->getMessage()]);
                    }

                    session()->forget(['checkout_data', 'razorpay_order_id', 'checkout_in_progress', 'callback_in_progress']);
                    return redirect()->route('customer.checkout.confirmation', $result['order']->id);
                }
            }

            session()->forget(['checkout_in_progress', 'callback_in_progress']);
            return redirect()->route('customer.checkout.payment.failed')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            session()->forget(['checkout_in_progress', 'callback_in_progress']);
            Log::error('Payment callback failed', ['error' => $e->getMessage()]);
            return redirect()->route('customer.checkout.payment.failed')->with('error', $e->getMessage());
        }
    }

    /* =====================================================
     | CONFIRMATION
     ===================================================== */
    public function confirmation($orderId)
    {
        $order = Order::where('customer_id', Auth::guard('customer')->id())
            ->with(['items.variant.product', 'shipments'])
            ->findOrFail($orderId);

        return view('customer.checkout.confirmation', compact('order'));
    }

    /* =====================================================
     | SHIPPING CHECK (SHIPROCKET)
     ===================================================== */
    public function checkShipping(Request $request)
    {
        $request->validate(['pincode' => 'required']);

        $cart = $this->cartHelper->getCart();
        $weight = $this->calculateCartWeight($cart);
        $dimensions = $this->calculateCartDimensions($cart);

        // 1. Check Serviceability via Delhivery
        $serviceability = $this->delhiveryService->checkServiceability($request->pincode, $weight, $dimensions);

        if (!$serviceability['success']) {
            return response()->json($serviceability);
        }

        // 2. Determine Best ETA
        $eta = $serviceability['estimated_delivery'] ?? 5;

        // 3. Fetch City & State
        $city = $serviceability['city'] ?? null;
        $state = $serviceability['state'] ?? null;

        // 4. Apply Custom Shipping Logic
        $customCost = $this->calculateShippingCost($cart);

        // 5. Construct Single "Standard Delivery" Option
        $customOption = [
            'courier_id' => 'standard', // Custom ID
            'name' => 'Standard Delivery',
            'rate' => $customCost,
            'estimated_days' => $eta,
            'service_type' => 'Standard'
        ];

        return response()->json([
            'success' => true,
            'available_couriers' => [$customOption],
            'estimated_delivery' => $eta,
            'city' => $city,
            'state' => $state,
            // 'raw_data' => $serviceability['raw_data'] ?? null // Debugging
        ]);
    }

    public function createRazorpayOrder(Request $request)
    {
        $cart = $this->cartHelper->getCart();

        if (empty($cart['items'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty'
            ], 400);
        }

        // Calculate shipping cost securely
        $shippingCost = $this->calculateShippingCost($cart);

        // Prepare data securely
        $data = $request->all();
        $data['shipping_cost'] = $shippingCost;

        // Store checkout data for callback
        session(['checkout_data' => $data]);

        // Calculate correct total including shipping
        $grandTotal = $cart['subtotal'] + $cart['tax_total'] + $shippingCost - ($cart['discount_total'] ?? 0);

        // Razorpay expects paise
        $amountInPaise = (int) round($grandTotal * 100);

        $razorpayOrder = $this->razorpayService
            ->createOrderByAmount($amountInPaise);

        return response()->json($razorpayOrder);
    }

    // --- Custom Logic ---
    private function calculateShippingCost($cart): float
    {
        // Logic: Fixed 69, Free if > 1999
        $threshold = 1999;
        $fixedRate = 69;

        // Ensure we check numeric value
        $subtotal = (float) $cart['subtotal'];

        // User request: "if cart value is more than 1999 then free delivery"
        // Assuming subtotal implies cart value.
        if ($subtotal > $threshold) {
            return 0;
        }

        return $fixedRate;
    }

    /* =====================================================
     | HELPERS
     ===================================================== */
    private function calculateCartDimensions($cart): array
    {
        $maxLength = 10;
        $maxWidth = 10;
        $maxHeight = 10;

        foreach ($cart['items'] as $item) {
            $variant = ProductVariant::where('sku', $item['sku'])->first();
            // Prioritize variant > product > default 10

            $l = $variant->length ?? ($item->product->length ?? 10);
            $w = $variant->width ?? ($item->product->width ?? 10);
            $h = $variant->height ?? ($item->product->height ?? 10);

            if ($l > $maxLength)
                $maxLength = $l;
            if ($w > $maxWidth)
                $maxWidth = $w;
            if ($h > $maxHeight)
                $maxHeight = $h;
        }

        return [
            'length' => $maxLength,
            'width' => $maxWidth,
            'height' => $maxHeight
        ];
    }

    private function calculateCartWeight($cart): float
    {
        $weight = 0;

        foreach ($cart['items'] as $item) {
            $variant = ProductVariant::where('sku', $item['sku'])->first();
            $itemWeight = $variant->weight ?? ($item->product->weight ?? 0.1);
            $weight += $itemWeight * $item['quantity'];
        }

        return max($weight, 0.1);
    }

    private function validateCheckout(Request $request): void
    {
        Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15'],
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => ['required', 'string', 'regex:/^[1-9][0-9]{5}$/'],
            'payment_method' => ['required', Rule::in(['online', 'cod'])],
            'terms_agree' => 'accepted',
        ], [
            'pincode.regex' => 'Please enter a valid 6-digit pincode.',
            'phone.regex' => 'Please enter a valid phone number.',
            'terms_agree.accepted' => 'You must agree to the terms and conditions.'
        ])->validate();
    }

    /* =====================================================
     | PAYMENT FAILED PAGE
     ===================================================== */
    public function paymentFailed()
    {
        return view('customer.checkout.payment_failed');
    }


}
