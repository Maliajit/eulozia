<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Shipping Controller
 * 
 * Purpose: Manages shipping zones, charges, and logistics integrations (e.g., Shiprocket).
 * 
 * Data Flow: 
 * - Configures logistics parameters used during checkout.
 * 
 * Database: 
 * - `shipping_charges`, `shipping_zones`: Persists logistics rules.
 * 
 * Dependencies: Admin API, External Logistics APIs.
 */
class ShippingController extends Controller
{
    public function index()  { return view('admin.shipping.index'); }
    public function charges() { return view('admin.shipping.charges'); }
}
