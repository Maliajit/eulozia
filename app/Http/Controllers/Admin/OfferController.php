<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Offer Controller
 * 
 * Purpose: Manages discounts, coupons, and promotional offers.
 * 
 * Data Flow: 
 * - Serves views for creating and managing offers.
 * - Integration with Checkout module for applying discounts.
 * 
 * Database: 
 * - `offers`: Stores discount types, values, limits, and validity dates.
 * 
 * Dependencies: Admin API, Customer Checkout Service.
 */
class OfferController extends Controller
{
    public function index() { return view('admin.offers.index'); }
    public function create() { return view('admin.offers.create'); }
}
