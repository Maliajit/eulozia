<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Banner;
use App\Models\HomeSection;
use App\Services\Customer\ProductService;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            /* ------------------------------
             | BANNERS
             |------------------------------*/
            $banners = Banner::where('status', true)->orderBy('sort_order')->get();

            /* ------------------------------
             | FEATURED PRODUCTS (Fixed below banner)
             |------------------------------*/
            $featuredProducts = collect([]);
            try {
                $featuredProducts = $this->productService->getProducts(
                    ['is_featured' => true, 'sort_by' => 'newest'],
                    8
                );
            } catch (\Exception $e) {
                Log::error('Error fetching featured products', ['error' => $e->getMessage()]);
            }

            /* ------------------------------
             | DYNAMIC HOME SECTIONS
             |------------------------------*/
            $sections = HomeSection::where('status', true)
                ->where('type', '!=', 'featured')
                ->where('title', '!=', 'Featured Collection')
                ->orderBy('sort_order')
                ->get();

            // Transform sections to include their products
            $sections->transform(function ($section) {
                if ($section->type === 'category' && $section->category_id) {
                    // Fetch products from category
                    // Assuming we want latest products from this category
                    $section->products = $this->productService->getProducts(
                        ['category_id' => $section->category_id, 'sort_by' => 'newest'],
                        8 // Limit 8 for grids/sliders
                    );
                } elseif ($section->type === 'custom_products' && !empty($section->product_ids)) {
                    // Fetch specific products
                    $products = Product::whereIn('id', $section->product_ids)
                        ->where('is_active', true)
                        ->get();

                    $section->products = $products->map(function ($product) {
                        return $this->productService->transformProductForListing($product);
                    });
                } else {
                    $section->products = collect([]);
                }

                return $section;
            });

            /* ------------------------------
             | TESTIMONIALS
             |------------------------------*/
            $testimonials = Testimonial::where('is_active', true)
                ->latest()
                ->limit(3)
                ->get();

            /* ------------------------------
             | BREADCRUMB DATA
             |------------------------------*/
            $breadcrumb = 'New Collection'; // Default
            if ($banners->count() > 0 && $banners->first()->title) {
                $breadcrumb = $banners->first()->title;
            } elseif ($sections->count() > 0) {
                $breadcrumb = $sections->first()->title;
            }

            /* ------------------------------
             | FEATURED CATEGORIES (Shop by Collection)
             |------------------------------*/
            $featuredCategories = Category::where('featured', true)
                ->where('status', true)
                ->with('image')
                ->orderBy('sort_order')
                ->get();

            /* ------------------------------
             | EXPLORE MORE COLLECTIONS
             |------------------------------*/
            // Fetch 2 random categories that are NOT featured (to avoid duplication with 'Shop By Collection')
            // and have an image.
            $exploreMoreCategories = Category::where('status', true)
                ->where('featured', false)
                ->whereNotNull('image_id')
                ->with('image')
                ->inRandomOrder()
                ->limit(2)
                ->get();

            return view('customer.home.index', compact(
                'banners',
                'sections',
                'featuredProducts',
                'testimonials',
                'breadcrumb',
                'featuredCategories',
                'exploreMoreCategories'
            ));

        } catch (\Throwable $e) {
            Log::error('Home page error', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('customer.home.index', [
                'banners' => collect(),
                'sections' => collect(),
                'testimonials' => collect(),
                'breadcrumb' => 'Home',
            ]);
        }
    }
}
