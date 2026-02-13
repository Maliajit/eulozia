<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Admin Category Controller
 * 
 * Purpose: Manages product categories hierarchy and metadata.
 * 
 * Data Flow: 
 * - Serves views for listing and managing categories.
 * - Interacts with Admin API for data persistence.
 * 
 * Database: 
 * - `categories`: Stores category names, parent IDs, slugs, and banners.
 * 
 * Dependencies: Admin API, Sidebar Navigation.
 */
class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function edit($id)
    {
        return view('admin.categories.edit', compact('id'));
    }

    public function show($id)
    {
        return view('admin.categories.show', ['id' => $id]);
    }
}
