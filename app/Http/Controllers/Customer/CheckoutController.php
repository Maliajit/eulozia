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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

use App\Models\Offer;

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

        $availableOffers = Offer::active()->whereNotNull('code')->get();

        return view('customer.checkout.index', [
            'cart' => $cart,
            'codAvailable' => $this->checkoutService->isCODAvailable(),
            'paymentMethods' => $this->checkoutService->getAvailablePaymentMethods(),
            'addresses' => Auth::guard('customer')->user()?->addresses ?? collect(),
            'availableOffers' => $availableOffers,
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
            /* Bypassed for now as per user request
            $pincode = $request->pincode;
            $serviceability = $this->delhiveryService->checkServiceability($pincode);

            if (!$serviceability['success']) {
                session()->forget('checkout_in_progress');
                return back()->with('error', $serviceability['message'])->withInput();
            }
            */

            // Enforce shipping cost calculation
            $cart = $this->cartHelper->getCart();
            $shippingCost = $this->calculateShippingCost($cart);
            $request->merge(['shipping_cost' => $shippingCost]);

            if ($request->payment_method === 'cod') {
                $response = $this->processCOD($request);
                session()->forget('checkout_in_progress');
                return $response;
            }

            $response = $this->processOnlinePayment($request);
            session()->forget('checkout_in_progress');
            return $response;
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
            try {
                $this->delhiveryService->createOrder($result['order']);
            } catch (\Exception $e) {
                Log::error('Delhivery order creation failed: ' . $e->getMessage());
            }
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
        $shippingCost = $this->calculateShippingCost($cart);

        $data = $request->all();
        $data['shipping_cost'] = $shippingCost;
        $data['payment_method'] = 'online';

        try {
            DB::beginTransaction();

            // Create order, items and update stock
            $order = $this->checkoutService->createOrder($data);
            $this->checkoutService->createOrderItems($order);
            $this->checkoutService->updateStock($order);

            $razorpayOrder = $this->razorpayService->createOrder($order, $order->grand_total);

            if (!$razorpayOrder['success']) {
                throw new \Exception($razorpayOrder['message']);
            }

            DB::commit();

            session(['checkout_data' => $data, 'last_order_id' => $order->id]);

            return view('customer.checkout.payment', [
                'keyId' => $razorpayOrder['key_id'],
                'orderId' => $razorpayOrder['order_id'],
                'amount' => $order->grand_total,
                'customer' => Auth::guard('customer')->user(),
                'order' => $order
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Razorpay Process Online Payment Failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    /* =====================================================
     | RAZORPAY CALLBACK
     ===================================================== */
    public function paymentCallback(Request $request)
    {
        Log::info('Razorpay Callback Received', $request->all());

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

            // Get the order - it should have been created in createRazorpayOrder
            $order = Order::whereHas('paymentAttempts', function ($q) use ($razorpayOrderId) {
                $q->where('attempt_id', $razorpayOrderId);
            })->orWhere('id', session('last_order_id'))->first();

            if (!$order) {
                throw new \Exception('Order not found. Please contact support.');
            }

            // Process payment verification and finalizing
            $paymentData = [
                'razorpay_payment_id' => $paymentId,
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_signature' => $signature
            ];

            $result = $this->razorpayService->processPayment($order, $paymentData);

            if (!$result['success']) {
                throw new \Exception($result['message']);
            }

            // Finalize order (clear cart, send email etc.)
            $this->checkoutService->finalizeOrder($order);

            // Try to create delhivery order
            try {
                $this->delhiveryService->createOrder($order);
            } catch (\Exception $e) {
                Log::error('Delhivery order creation failed on callback', ['error' => $e->getMessage()]);
            }

            session()->forget(['checkout_data', 'razorpay_order_id', 'checkout_in_progress', 'callback_in_progress', 'last_order_id']);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('customer.checkout.confirmation', $order->id)
                ]);
            }

            return redirect()->route('customer.checkout.confirmation', $order->id);

        } catch (\Exception $e) {
            session()->forget(['callback_in_progress']);
            Log::error('Payment callback failed', ['error' => $e->getMessage()]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'redirect_url' => route('customer.checkout.payment.failed')
                ], 400);
            }

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
        $request->validate(['pincode' => 'required|string|size:6']);
        $pincode = $request->pincode;

        $cart = $this->cartHelper->getCart();
        $city = null;
        $state = null;

        try {
            // Fetch city and state from Indian Pincode API
            $response = Http::timeout(10)->get("https://api.postalpincode.in/pincode/{$pincode}");
            
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data[0]['Status']) && $data[0]['Status'] === 'Success' && !empty($data[0]['PostOffice'])) {
                    // Collect potential names
                    $foundCity = null;
                    $foundState = null;

                    foreach ($data[0]['PostOffice'] as $office) {
                        // Priority: District > Division > Block > Name
                        $potential = $office['District'] ?? $office['Division'] ?? $office['Block'] ?? $office['Name'] ?? '';
                        if (!empty($potential) && strtolower($potential) !== 'unknown') {
                            $foundCity = $potential;
                            $foundState = $office['State'] ?? null;
                            break;
                        }
                    }

                    if ($foundCity) {
                        $city = $foundCity;
                        $state = $foundState ?? $state;
                    } else {
                        // Last resort: just take the name of the first post office
                        $city = $data[0]['PostOffice'][0]['Name'] ?? null;
                        $state = $data[0]['PostOffice'][0]['State'] ?? null;
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Pincode lookup failed: ' . $e->getMessage());
        }

        // Final fallback if still null
        $city = $city ?? 'Standard Location';
        $state = $state ?? 'India';

        $eta = 5; // Standard ETA
        $customCost = $this->calculateShippingCost($cart);

        $customOption = [
            'courier_id' => 'standard',
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

        try {
            $this->validateCheckout($request);
            $this->checkoutService->validateCart();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }

        // Calculate shipping cost securely
        $shippingCost = $this->calculateShippingCost($cart);

        // Prepare data securely
        $data = $request->all();
        $data['shipping_cost'] = $shippingCost;
        $data['payment_method'] = 'online';

        try {
            DB::beginTransaction();

            // Create order, items and update stock (reserves stock)
            $order = $this->checkoutService->createOrder($data);
            $this->checkoutService->createOrderItems($order);
            $this->checkoutService->updateStock($order);

            // Calculate correct total including shipping
            $grandTotal = $order->grand_total;

            // Razorpay expects paise
            $amountInPaise = (int) round($grandTotal * 100);

            $razorpayOrder = $this->razorpayService->createOrder($order, $grandTotal);

            if (!$razorpayOrder['success']) {
                throw new \Exception($razorpayOrder['message']);
            }

            DB::commit();

            // Store checkout data and order_id for callback
            session(['checkout_data' => $data, 'last_order_id' => $order->id]);

            return response()->json($razorpayOrder);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Razorpay Order Creation Failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize payment: ' . $e->getMessage()
            ], 500);
        }
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
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'min:10', 'max:15'],
            'address1' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => ['required', 'string', 'regex:/^[1-9][0-9]{5}$/'],
            'payment_method' => ['required', Rule::in(['online', 'cod'])],
            'terms_agree' => 'required',
        ], [
            'pincode.regex' => 'Please enter a valid 6-digit pincode.',
            'terms_agree.required' => 'You must agree to the terms and conditions.'
        ])->validate();

        // Merge fields for Service consumption
        $request->merge([
            'full_name' => $request->firstName . ' ' . $request->lastName,
            'address' => $request->address1 . ($request->address2 ? ', ' . $request->address2 : ''),
            'country' => 'India' // Default if not in form
        ]);
    }

    /* =====================================================
     | PAYMENT FAILED PAGE
     ===================================================== */
    public function paymentFailed()
    {
        return view('customer.checkout.payment_failed');
    }


}
