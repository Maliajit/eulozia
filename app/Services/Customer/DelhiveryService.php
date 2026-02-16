<?php

namespace App\Services\Customer;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DelhiveryService
{
    protected $baseUrl;
    protected $apiToken;
    protected $client;

    public function __construct()
    {
        $this->baseUrl = config('services.delhivery.base_url', 'https://track.delhivery.com/');
        $this->apiToken = config('services.delhivery.api_token');

        // Using withoutVerifying() if needed, but normally Delhivery SSL is fine.
        // Keeping it consistent with ShiprocketService if it was needed there.
        $this->client = Http::withHeaders([
            'Authorization' => "Token {$this->apiToken}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiToken);
    }

    /**
     * Check serviceability for a pincode
     * Delhivery Pincode API: /c/api/pin-codes/json/
     */
    public function checkServiceability(string $pincode, float $weight = 0.5, array $dimensions = [])
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Delhivery API is not configured. Please add DELHIVERY_API_TOKEN to your .env file.'
            ];
        }

        try {
            Log::info('Checking Delhivery serviceability', ['pincode' => $pincode]);

            $response = $this->client->get($this->baseUrl . 'c/api/pin-codes/json/', [
                'filter_codes' => $pincode
            ]);

            if (!$response->successful()) {
                Log::error('Delhivery serviceability check failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return [
                    'success' => false,
                    'message' => 'Shipping service unavailable. Please try again later.'
                ];
            }

            $data = $response->json();

            // Delhivery returns an array of codes in 'delivery_codes'
            $deliveryCodes = $data['delivery_codes'] ?? [];

            if (empty($deliveryCodes)) {
                return [
                    'success' => false,
                    'message' => "Sorry, we do not currently ship to this pincode ($pincode)."
                ];
            }

            $serviceInfo = $deliveryCodes[0]['postal_code'] ?? null;

            if (!$serviceInfo || ($serviceInfo['is_serviceable'] ?? 'N') !== 'Y') {
                return [
                    'success' => false,
                    'message' => "Sorry, we do not currently ship to this pincode ($pincode)."
                ];
            }

            // Map Delhivery response to match what the controller expects
            // CheckoutController expects 'available_couriers' list
            return [
                'success' => true,
                'available_couriers' => [
                    [
                        'courier_id' => 'delhivery',
                        'name' => 'Delhivery',
                        'rate' => 0, // Rate is calculated in controller
                        'estimated_days' => 5, // Default estimate, can be refined
                        'service_type' => 'Standard',
                        'cod' => ($serviceInfo['cod'] ?? 'N') === 'Y'
                    ]
                ],
                'city' => $serviceInfo['city'] ?? null,
                'state' => $serviceInfo['state'] ?? null,
                'raw_data' => $data
            ];

        } catch (Exception $e) {
            Log::error('Delhivery serviceability error', [
                'pincode' => $pincode,
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'message' => 'Serviceability check error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create order in Delhivery (Stub)
     */
    public function createOrder($order)
    {
        // Full order creation logic can be added here
        Log::info('Delhivery createOrder stub called', ['order_id' => $order->id]);
        return ['success' => true];
    }
}
