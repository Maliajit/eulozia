<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Inventory Controller
 * 
 * Purpose: Manages stock levels, inventory history, and stock adjustments.
 * 
 * Data Flow: 
 * - Displays views for stock monitoring and adjustment logs.
 * - Direct updates are typically handled via Admin Inventory API.
 * 
 * Database: 
 * - `product_variants`: Current stock levels.
 * - `inventory_logs`: History of stock changes.
 * 
 * Dependencies: Admin API, Sidebar Navigation.
 */
class InventoryController extends Controller
{
    public function index()
    {
        return view('admin.inventory.index');
    }

    public function history()
    {
        return view('admin.inventory.history');
    }

    public function updateStock($id)
    {
        return view('admin.inventory.update', compact('id'));
    }
}
