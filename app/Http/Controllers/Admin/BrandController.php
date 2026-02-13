<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Brand Controller
 * 
 * Purpose: Handles views for managing product brands.
 * 
 * Data Flow: 
 * - Serves Blade views for listing, creating, and editing brands.
 * - Actual data operations are handled via Admin API.
 * 
 * Database: 
 * - `brands`: Stores brand names, slugs, and logos.
 * 
 * Dependencies: Admin API Routes, Brands Datatable (JS).
 */
class BrandController extends Controller
{
    public function index()  { return view('admin.brands.index'); }
    public function create() { return view('admin.brands.create'); }
    public function edit($id) { return view('admin.brands.edit', compact('id')); }
}
