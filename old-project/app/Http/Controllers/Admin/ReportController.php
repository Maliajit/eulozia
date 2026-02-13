<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Report Controller
 * 
 * Purpose: Strategic reporting module for Sales, Customers, and Products.
 * 
 * Data Flow: 
 * - Serves specialized views for data visualization and historical analysis.
 * 
 * Database: 
 * - `orders`, `order_items`, `customers`, `products`: Aggregated for reporting.
 * 
 * Dependencies: Admin Dashboards and Charting libraries.
 */
class ReportController extends Controller
{
    public function index()     { return view('admin.reports.index'); }
    public function sales()     { return view('admin.reports.sales'); }
    public function customers() { return view('admin.reports.customers'); }
    public function products()  { return view('admin.reports.products'); }
}
