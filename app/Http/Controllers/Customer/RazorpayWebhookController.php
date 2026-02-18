<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Customer\RazorpayService;
use App\Services\Customer\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RazorpayWebhookController extends Controller
{
    public function __construct(
        protected RazorpayService $razorpayService,
        protected CheckoutService $checkoutService
    ) {
    }

    public function handle(Request $request)
    {
        $payload = $request->all();
        $signature = $request->header('X-Razorpay-Signature');

        Log::info('Razorpay Webhook Received', [
            'event' => $payload['event'] ?? 'unknown',
            'order_id' => $payload['payload']['payment']['entity']['order_id'] ?? 'n/a'
        ]);

        if (!$this->razorpayService->verifyWebhookSignature($request->getContent(), $signature)) {
            Log::warning('Razorpay Webhook Signature Verification Failed');
            return response()->json(['status' => 'invalid_signature'], 400);
        }

        try {
            switch ($payload['event']) {
                case 'payment.captured':
                    return $this->handlePaymentCaptured($payload);
                case 'payment.failed':
                    return $this->handlePaymentFailed($payload);
                default:
                    Log::info('Unhandled Razorpay Webhook Event: ' . ($payload['event'] ?? 'unknown'));
                    return response()->json(['status' => 'ignored']);
            }
        } catch (\Exception $e) {
            Log::error('Razorpay Webhook Processing Error', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    protected function handlePaymentCaptured(array $payload)
    {
        $paymentEntity = $payload['payload']['payment']['entity'];
        $razorpayOrderId = $paymentEntity['order_id'];
        $paymentId = $paymentEntity['id'];

        $order = Order::whereHas('paymentAttempts', function ($q) use ($razorpayOrderId) {
            $q->where('attempt_id', $razorpayOrderId);
        })->orWhere('order_number', $paymentEntity['notes']['order_number'] ?? null)
            ->first();

        if (!$order) {
            Log::warning('Order not found for Razorpay Webhook', ['razorpay_order_id' => $razorpayOrderId]);
            return response()->json(['status' => 'not_found'], 404);
        }

        if ($order->payment_status === 'paid') {
            Log::info('Order already marked as paid, skipping webhook processing', ['order_id' => $order->id]);
            return response()->json(['status' => 'already_processed']);
        }

        // Standardize the payment data for processPayment
        $paymentData = [
            'razorpay_payment_id' => $paymentId,
            'razorpay_order_id' => $razorpayOrderId,
            'razorpay_signature' => 'webhook_verified' // or actual signature if verified
        ];

        $result = $this->razorpayService->processPayment($order, $paymentData);

        if ($result['success']) {
            $this->checkoutService->finalizeOrder($order);
            Log::info('Order confirmed via Razorpay Webhook', ['order_id' => $order->id]);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']], 400);
    }

    protected function handlePaymentFailed(array $payload)
    {
        $paymentEntity = $payload['payload']['payment']['entity'];
        $razorpayOrderId = $paymentEntity['order_id'];

        $order = Order::whereHas('paymentAttempts', function ($q) use ($razorpayOrderId) {
            $q->where('attempt_id', $razorpayOrderId);
        })->first();

        if ($order) {
            $order->update([
                'payment_status' => 'failed',
                'status' => 'failed'
            ]);
            Log::info('Order marked as failed via Razorpay Webhook', ['order_id' => $order->id]);
        }

        return response()->json(['status' => 'success']);
    }
}
