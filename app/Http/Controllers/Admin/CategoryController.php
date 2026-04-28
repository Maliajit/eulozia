<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\SpecificationGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function getData(Request $request)
    {
        try {
            $query = Category::withCount('products')->with('parent', 'image');

            if ($request->filled('sort')) {
                $query->orderBy($request->sort, $request->direction ?? 'asc');
            } else {
                $query->orderBy('sort_order', 'asc');
            }

            $perPage = $request->per_page ?? 10;
            $categories = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching category data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching category data.'
            ], 500);
        }
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'status' => 'boolean',
            'image_id' => 'nullable|integer',
        ]);

        try {
            $category = Category::create($request->all());
            return response()->json(['success' => true, 'message' => 'Category created successfully', 'data' => $category]);
        } catch (\Exception $e) {
            \Log::error('Error creating category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the category. Please try again.'
            ], 500);
        }
    }

    public function edit($id)
    {
        return view('admin.categories.edit', compact('id'));
    }

    public function show($id)
    {
        try {
            $category = Category::with(['children', 'parent', 'image', 'attributes', 'specificationGroups'])->findOrFail($id);

            // Append spec_group_ids for frontend compatibility if needed
            $category->spec_group_ids = $category->specificationGroups->pluck('id')->toArray();

            if (request()->wantsJson()) {
                return response()->json(['success' => true, 'data' => $category]);
            }
            return view('admin.categories.show', ['id' => $id, 'category' => $category]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
            }
            return redirect()->route('admin.categories.index')->with('error', 'Category not found.');
        } catch (\Exception $e) {
            \Log::error('Error showing category: ' . $e->getMessage());
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'An error occurred while loading category details.'], 500);
            }
            return redirect()->route('admin.categories.index')->with('error', 'An error occurred while loading category details.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
                'parent_id' => 'nullable|exists:categories,id',
                'sort_order' => 'integer|min:0',
                'status' => 'boolean',
                'featured' => 'boolean',
                'show_in_nav' => 'boolean',
                'description' => 'nullable|string',
                'image_id' => 'nullable|integer',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'spec_group_ids' => 'nullable|array',
                'spec_group_ids.*' => 'exists:specification_groups,id',
                'attributes' => 'nullable|array',
                'attributes.*.is_required' => 'boolean',
                'attributes.*.is_filterable' => 'boolean',
                'attributes.*.sort_order' => 'integer|min:0',
            ]);

            \DB::beginTransaction();

            $category->update($request->all());

            // Sync specification groups
            if ($request->has('spec_group_ids')) {
                $category->specificationGroups()->sync($request->input('spec_group_ids'));
            }

            // Sync attributes with pivot data
            if ($request->has('attributes')) {
                $syncData = [];
                $attributes = $request->input('attributes');
                foreach ($attributes as $attrId => $pivotData) {
                    $syncData[$attrId] = [
                        'is_required' => $pivotData['is_required'] ?? 0,
                        'is_filterable' => $pivotData['is_filterable'] ?? 0,
                        'sort_order' => $pivotData['sort_order'] ?? 0,
                    ];
                }
                $category->attributes()->sync($syncData);
            } else {
                $category->attributes()->sync([]);
            }

            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Category updated successfully', 'data' => $category]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error updating category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the category. Please try again.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Check if has products or children
            if ($category->children()->exists()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete category. It has sub-categories.'], 400);
            }

            if ($category->products()->exists()) {
                return response()->json(['success' => false, 'message' => 'Cannot delete category. It has associated products.'], 400);
            }

            $category->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error deleting category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the category. Please try again.'
            ], 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No categories selected.'], 400);
            }

            // Optional: Check for dependencies before bulk deleting?
            // For now, simple bulk delete but wrapped in try-catch.
            $deletedCount = Category::whereIn('id', $ids)->delete();

            return response()->json(['success' => true, 'data' => ['deleted_count' => $deletedCount]]);
        } catch (\Exception $e) {
            \Log::error('Error in bulk category deletion: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while performing bulk deletion.'
            ], 500);
        }
    }

    public function getDropdown(Request $request)
    {
        $query = Category::whereNull('parent_id')->with('children');
        if ($request->exclude_id) {
            $query->where('id', '!=', $request->exclude_id);
        }
        $categories = $query->get();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function statistics()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'total_categories' => Category::count(),
                    'active_categories' => Category::where('status', 1)->count(),
                    'main_categories' => Category::whereNull('parent_id')->count(),
                    'popular_category' => Category::withCount('products')->orderByDesc('products_count')->first()
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching category statistics: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error fetching statistics.'], 500);
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->status = !$category->status;
            $category->save();
            return response()->json(['success' => true, 'message' => 'Status updated']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error toggling category status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating status.'], 500);
        }
    }

    public function bulkStatus(Request $request)
    {
        try {
            $ids = $request->ids;
            $status = $request->status;
            if (empty($ids)) {
                return response()->json(['success' => false, 'message' => 'No categories selected.'], 400);
            }

            Category::whereIn('id', $ids)->update(['status' => $status]);
            return response()->json(['success' => true, 'message' => 'Status updated for selected categories']);
        } catch (\Exception $e) {
            \Log::error('Error in bulk category status update: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating statuses.'], 500);
        }
    }

    public function getAttributesDropdown()
    {
        $attributes = Attribute::select('id', 'name', 'code')->get();
        return response()->json(['success' => true, 'data' => $attributes]);
    }

    public function getSpecGroupsDropdown()
    {
        $groups = SpecificationGroup::select('id', 'name')->get();
        return response()->json(['success' => true, 'data' => $groups]);
    }
}
