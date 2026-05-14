<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Media;
use App\Models\SeoMetadata;
use App\Http\Requests\Api\Admin\BrandRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Admin Brand Controller
 * 
 * Purpose: Handles views and data operations for managing product brands.
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
    public function index()
    {
        return view('admin.brands.index');
    }
    public function create()
    {
        return view('admin.brands.create');
    }
    public function edit($id)
    {
        return view('admin.brands.edit', compact('id'));
    }

    /**
     * Get brands data for datatables
     */
    public function getData(Request $request)
    {
        try {
            $query = Brand::with(['logo'])->withCount('products');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status === 'active' ? 1 : 0);
            }

            $brands = $query->latest()->paginate($request->get('per_page', 10));

            return response()->json([
                'success' => true,
                'data' => $brands->items(),
                'meta' => [
                    'current_page' => $brands->currentPage(),
                    'last_page' => $brands->lastPage(),
                    'per_page' => $brands->perPage(),
                    'total' => $brands->total()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching brands data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load brands data.'], 500);
        }
    }

    /**
     * Store a new brand
     */
    public function store(BrandRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $logoFile = $request->file('logo');
                $filename = 'brand_' . time() . '.' . $logoFile->getClientOriginalExtension();
                $path = $logoFile->storeAs('brands/logos', $filename, 'public');

                $media = Media::create([
                    'file_name' => $logoFile->getClientOriginalName(),
                    'file_path' => $path,
                    'disk' => 'public',
                    'mime_type' => $logoFile->getMimeType(),
                    'file_type' => 'image',
                    'file_size' => $logoFile->getSize(),
                    'uploaded_by' => auth()->id(),
                    'uploader_type' => 'admin',
                ]);
                $data['logo_id'] = $media->id;
            }

            $data['status'] = ($request->status === 'active' || $request->status == 1);
            $brand = Brand::create($data);

            if (!empty($data['meta_title']) || !empty($data['meta_description'])) {
                SeoMetadata::create([
                    'entity_type' => Brand::class,
                    'entity_id' => $brand->id,
                    'meta_title' => $data['meta_title'] ?? null,
                    'meta_description' => $data['meta_description'] ?? null,
                    'meta_keywords' => $data['meta_keywords'] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Brand created successfully', 'data' => $brand]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating brand: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to create brand. Please try again.'], 500);
        }
    }

    /**
     * Update brand
     */
    public function update(BrandRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::findOrFail($id);
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                if ($brand->logo) {
                    Storage::disk('local')->delete($brand->logo->file_path);
                    $brand->logo->delete();
                }

                $logoFile = $request->file('logo');
                $filename = 'brand_' . time() . '.' . $logoFile->getClientOriginalExtension();
                $path = $logoFile->storeAs('brands/logos', $filename, 'local');

                $media = Media::create([
                    'file_name' => $logoFile->getClientOriginalName(),
                    'file_path' => $path,
                    'disk' => 'local',
                    'mime_type' => $logoFile->getMimeType(),
                    'file_type' => 'image',
                    'file_size' => $logoFile->getSize(),
                    'uploaded_by' => auth()->id(),
                    'uploader_type' => 'admin',
                ]);
                $data['logo_id'] = $media->id;
            }

            $data['status'] = ($request->status === 'active' || $request->status == 1);
            $brand->update($data);

            if (!empty($data['meta_title']) || !empty($data['meta_description'])) {
                SeoMetadata::updateOrCreate(
                    ['entity_type' => Brand::class, 'entity_id' => $brand->id],
                    [
                        'meta_title' => $data['meta_title'] ?? null,
                        'meta_description' => $data['meta_description'] ?? null,
                        'meta_keywords' => $data['meta_keywords'] ?? null,
                    ]
                );
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Brand updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating brand: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update brand. Please try again.'], 500);
        }
    }

    /**
     * Delete brand
     */
    public function destroy($id)
    {
        try {
            $brand = Brand::findOrFail($id);

            if ($brand->products()->exists()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete brand. It has associated products.'], 400);
            }

            if ($brand->logo) {
                Storage::disk('local')->delete($brand->logo->file_path);
                $brand->logo->delete();
            }

            $brand->seoMetadata()->delete();
            $brand->delete();

            return response()->json(['success' => true, 'message' => 'Brand deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting brand: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete brand.'], 500);
        }
    }

    /**
     * Toggle brand status
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            $brand = Brand::findOrFail($id);
            $brand->status = !$brand->status;
            $brand->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error toggling brand status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    /**
     * Bulk delete brands
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids))
            return response()->json(['success' => false, 'message' => 'No brands selected.'], 400);

        DB::beginTransaction();
        try {
            $brands = Brand::whereIn('id', $ids)->get();
            $deletedCount = 0;

            foreach ($brands as $brand) {
                if (!$brand->products()->exists()) {
                    if ($brand->logo) {
                        Storage::disk('local')->delete($brand->logo->file_path);
                        $brand->logo->delete();
                    }
                    $brand->seoMetadata()->delete();
                    $brand->delete();
                    $deletedCount++;
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => $deletedCount . ' brand(s) deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk delete brands: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to perform bulk delete.'], 500);
        }
    }

    /**
     * Bulk status update
     */
    public function bulkStatus(Request $request)
    {
        $ids = $request->ids;
        $status = $request->status === 'active' ? 1 : 0;

        if (empty($ids))
            return response()->json(['success' => false, 'message' => 'No brands selected.'], 400);

        try {
            Brand::whereIn('id', $ids)->update(['status' => $status]);
            return response()->json(['success' => true, 'message' => 'Status updated for selected brands.']);
        } catch (\Exception $e) {
            Log::error('Error in bulk status update brands: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
    }

    /**
     * Brand statistics
     */
    public function statistics()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'total' => Brand::count(),
                    'active' => Brand::where('status', 1)->count(),
                    'inactive' => Brand::where('status', 0)->count(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching brand statistics: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to load statistics.'], 500);
        }
    }
}
