<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('customer.checkout.index');
    }

    public function payment()
    {
        return view('customer.checkout.payment');
    }

    public function confirmation()
    {
        return view('customer.checkout.confirmation');
    }

    public function process(Request $request)
    {
        // Mock processing
        return response()->json([
            'success' => true,
            'order_id' => 'ORD-' . strtoupper(uniqid())
        ]);
    }

    public function processCod(Request $request)
    {
        // Mock COD processing
        return response()->json([
            'success' => true,
            'order_id' => 'ORD-' . strtoupper(uniqid())
        ]);
    }

    public function success()
    {
        return view('customer.checkout.success');
    }
}
