<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Admin Testimonial Controller
 * 
 * Purpose: Manages customer testimonials displayed on the storefront.
 * 
 * Data Flow: 
 * - CRUD for testimonials, including ratings and author designations.
 * 
 * Database: 
 * - `testimonials`: Stores feedback content, author names, and status.
 * 
 * Dependencies: Admin Layout, CRM Module.
 */
class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            Testimonial::create($request->all());
            DB::commit();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Testimonial store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred while creating the testimonial. Please try again.');
        }
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $testimonial->update($request->all());
            DB::commit();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Testimonial update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred while updating the testimonial. Please try again.');
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        DB::beginTransaction();
        try {
            $testimonial->delete();
            DB::commit();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Testimonial delete error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the testimonial. Please try again.');
        }
    }
}
