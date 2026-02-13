<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

/**
 * Admin Banner Controller
 * 
 * Purpose: Manages CRM banners/sliders for the customer-facing home page.
 * 
 * Data Flow: 
 * - CRUD operations for banners.
 * - Image paths are stored as strings (referenced from Media module).
 * - Toggle status for enabling/disabling sliders on the front-end.
 * 
 * Database: 
 * - `banners`: Stores banner titles, images, links, and sort orders.
 * 
 * Dependencies: Media Controller (for image selection).
 */
class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('admin.crm.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.crm.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|string',
            'cta_text' => 'nullable|string|max:50',
            'cta_link' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        Banner::create($request->all());

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.crm.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|string',
            'cta_text' => 'nullable|string|max:50',
            'cta_link' => 'nullable|string|max:255',
            'sort_order' => 'integer',
        ]);

        $banner->update($request->all());

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->status = !$banner->status;
        $banner->save();
        return response()->json(['success' => true, 'status' => $banner->status]);
    }
}
