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
        $query = Category::withCount('products')->with('parent', 'image');

        if ($request->filled('sort')) {
            $query->orderBy($request->sort, $request->direction ?? 'asc');
        } else {
            $query->orderBy('sort_order', 'asc');
        }

        if ($request->filled('search')) { // Filter by name/slug/description if searching
            $search = $request->search;
            // Tabulator might send filters as array, or we can handle simple search
        }

        $perPage = $request->per_page ?? 10;
        $categories = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
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
            'image_id' => 'nullable|integer', // Assuming media library returns ID
            // Add other fields validation
        ]);

        $category = Category::create($request->all());

        return response()->json(['success' => true, 'message' => 'Category created successfully', 'data' => $category]);
    }

    public function edit($id)
    {
        return view('admin.categories.edit', compact('id'));
    }

    public function show($id)
    {
        $category = Category::with(['children', 'parent', 'image', 'attributes', 'specificationGroups'])->findOrFail($id);

        // Append spec_group_ids for frontend compatibility if needed
        $category->spec_group_ids = $category->specificationGroups->pluck('id')->toArray();

        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'data' => $category]);
        }
        return view('admin.categories.show', ['id' => $id, 'category' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        \Log::info("Updating category", [
            'id' => $id,
            'received_attributes' => $request->input('attributes'),
            'received_spec_groups' => $request->input('spec_group_ids')
        ]);

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
            $syncResult = $category->attributes()->sync($syncData);
            \Log::info("Attributes sync results", ['result' => $syncResult]);
        } else {
            // If attributes key is missing, should we clear them?
            // Usually yes if we want to allow removing all attributes
            $category->attributes()->sync([]);
            \Log::info("Attributes cleared (none received)");
        }

        return response()->json(['success' => true, 'message' => 'Category updated successfully', 'data' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Check if has products or children?
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Category::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'data' => ['deleted_count' => count($ids)]]);
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
        return response()->json([
            'success' => true,
            'data' => [
                'total_categories' => Category::count(),
                'active_categories' => Category::where('status', 1)->count(), // Assuming status 1 is active
                'main_categories' => Category::whereNull('parent_id')->count(),
                'popular_category' => Category::withCount('products')->orderByDesc('products_count')->first()
            ]
        ]);
    }

    public function toggleStatus(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->status = !$category->status;
        $category->save();
        return response()->json(['success' => true, 'message' => 'Status updated']);
    }

    public function bulkStatus(Request $request)
    {
        $ids = $request->ids;
        $status = $request->status;
        Category::whereIn('id', $ids)->update(['status' => $status]);
        return response()->json(['success' => true, 'message' => 'Status updated for selected categories']);
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
