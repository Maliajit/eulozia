<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Admin Review Controller
 * 
 * Purpose: Manages product reviews and ratings submitted by customers.
 * 
 * Data Flow: 
 * - Moderates reviews (Approve/Reject).
 * - Aggregates ratings for product performance metrics.
 * 
 * Database: 
 * - `reviews`: Stores user ratings, review text, and status.
 * - `products`: Linked for product-specific feedback.
 * 
 * Dependencies: FontAwesome (for star ratings), Sidebar Navigation.
 */
class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $products = Product::select('id', 'name')->get();
        return view('admin.reviews.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_name' => 'required|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string',
            'status' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            Review::create($request->all());
            DB::commit();
            return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Review store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred while creating the review. Please try again.');
        }
    }

    public function edit(Review $review)
    {
        $products = Product::select('id', 'name')->get();
        return view('admin.reviews.edit', compact('review', 'products'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_name' => 'required|string|max:255',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|string',
            'status' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $review->update($request->all());
            DB::commit();
            return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Review update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'An error occurred while updating the review. Please try again.');
        }
    }

    public function destroy(Review $review)
    {
        DB::beginTransaction();
        try {
            $review->delete();
            DB::commit();
            return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin Review delete error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the review. Please try again.');
        }
    }
}
