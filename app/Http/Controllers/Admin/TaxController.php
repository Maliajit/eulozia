<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Tax Controller
 * 
 * Purpose: Manages tax classes and rates applied to products.
 * 
 * Data Flow: 
 * - Defines tax rules used in price calculations across the catalog and checkout.
 * 
 * Database: 
 * - `tax_classes`, `tax_rates`: Stores tax definitions.
 * 
 * Dependencies: Admin API, Sidebar Navigation.
 */
class TaxController extends Controller
{
    public function index()
    {
        return view('admin.taxes.index');
    }
}
