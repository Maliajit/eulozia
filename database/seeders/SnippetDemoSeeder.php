<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SnippetDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for clean seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // 1. Create Main Categories with snippet images (Shop by Collection)
        $categoriesData = [
            ['name' => 'Hoodies', 'slug' => 'hoodies', 'image' => 'https://blacksilver.in/wp-content/uploads/2018/07/White-Hoodie-copy.png'],
            ['name' => 'T-Shirts', 'slug' => 'tshirts', 'image' => 'http://pngimg.com/uploads/tshirt/tshirt_PNG5450.png'],
            ['name' => 'Joggers', 'slug' => 'joggers', 'image' => 'https://www.pngarts.com/files/3/Jogger-Pant-PNG-Download-Image.png'],
            ['name' => 'Co-Ord Sets', 'slug' => 'cordsets', 'image' => 'https://i.pinimg.com/originals/3d/72/b0/3d72b022ead18e8411c0edd68dff429b.png'],
            ['name' => 'Sweatshirts', 'slug' => 'sweatshirts', 'image' => 'https://i5.walmartimages.com/asr/49093c2c-f8ad-45a4-8c1a-b583c394d491_1.58dd1a7d1ea1ff52c06bf1afb9f9a0cf.jpeg'],
            ['name' => 'Polos', 'slug' => 'polos', 'image' => 'https://png.pngtree.com/png-clipart/20230313/original/pngtree-realistic-white-t-shirt-vector-for-mockup-png-image_8987565.png'],
        ];

        $mainCategoryIds = [];
        foreach ($categoriesData as $index => $data) {
            $media = Media::create([
                'file_name' => $data['slug'] . '.png',
                'file_path' => $data['image'],
                'disk' => 'url',
                'mime_type' => 'image/png',
                'file_type' => 'image',
                'alt_text' => $data['name'],
            ]);

            $cat = Category::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'status' => true,
                    'featured' => true,
                    'show_in_nav' => true,
                    'image_id' => $media->id,
                    'sort_order' => $index + 1,
                ]
            );
            $mainCategoryIds[] = $cat->id;
        }

        // 2. Create Special Categories for Home Sections (Not shown in "Shop by Collection")
        $specialCategories = [
            ['name' => 'Featured Collection', 'slug' => 'featured-collection'],
            ['name' => 'New Arrivals', 'slug' => 'new-arrivals-home'],
            ['name' => 'Best Sellers', 'slug' => 'best-sellers-home'],
        ];

        $specialCategoryIds = [];
        foreach ($specialCategories as $data) {
            $cat = Category::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'status' => true,
                    'featured' => false, // Don't show in "Shop by Collection"
                    'show_in_nav' => false, // Don't show in Navbar
                ]
            );
            $specialCategoryIds[$data['slug']] = $cat->id;
        }

        // 3. Create Products from snippet
        $defaultProductImages = [
            'https://godevil.in/cdn/shop/products/paisely-design-printed-green-shirt-for-men-860980.jpg?v=1695318274',
            'https://www.ottostore.com/cdn/shop/files/ADS09041_1800x1800.jpg?v=1748666820',
            'https://blackberrys.com/cdn/shop/files/Formal_Grey_Printed_Shirt_Wiper-MS013772G1-image1_1600x.jpg?v=1735213165',
        ];

        $productsData = [
            [
                'name' => 'A LUXURY HI FASHION DOUBLE POCKET CLUB SHIRT',
                'slug' => Str::slug('A LUXURY HI FASHION DOUBLE POCKET CLUB SHIRT'),
                'price' => 2239,
                'compare_price' => 22799,
                'is_featured' => true,
                'special_cats' => ['featured-collection', 'new-arrivals-home'],
                'images' => $defaultProductImages,
            ],
            [
                'name' => 'CHECKERED FORMAL SHIRT',
                'slug' => Str::slug('CHECKERED FORMAL SHIRT'),
                'price' => 2239,
                'compare_price' => 22799,
                'is_new' => true,
                'special_cats' => ['best-sellers-home', 'new-arrivals-home'],
                'images' => $defaultProductImages,
            ],
            [
                'name' => 'Casual Shirt 1',
                'slug' => 'casual-shirt-1',
                'price' => 1299,
                'compare_price' => 1599,
                'is_new' => true,
                'special_cats' => ['new-arrivals-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Casual Shirt 2',
                'slug' => 'casual-shirt-2',
                'price' => 1299,
                'compare_price' => 1599,
                'is_new' => true,
                'special_cats' => ['new-arrivals-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Casual Shirt 3',
                'slug' => 'casual-shirt-3',
                'price' => 1299,
                'compare_price' => 1599,
                'is_new' => true,
                'special_cats' => ['new-arrivals-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Casual Shirt 4',
                'slug' => 'casual-shirt-4',
                'price' => 1299,
                'compare_price' => 1599,
                'is_new' => true,
                'special_cats' => ['new-arrivals-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Premium Tee 1',
                'slug' => 'premium-tee-1',
                'price' => 999,
                'compare_price' => 1299,
                'is_bestseller' => true,
                'special_cats' => ['best-sellers-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Premium Tee 2',
                'slug' => 'premium-tee-2',
                'price' => 999,
                'compare_price' => 1299,
                'is_bestseller' => true,
                'special_cats' => ['best-sellers-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Premium Tee 3',
                'slug' => 'premium-tee-3',
                'price' => 999,
                'compare_price' => 1299,
                'is_bestseller' => true,
                'special_cats' => ['best-sellers-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Premium Tee 4',
                'slug' => 'premium-tee-4',
                'price' => 999,
                'compare_price' => 1299,
                'is_bestseller' => true,
                'special_cats' => ['best-sellers-home'],
                'images' => ['https://i.pinimg.com/originals/2f/3c/48/2f3c48c766f2c27752f8d6b214877952.jpg'],
            ],
            [
                'name' => 'Celestial Veil Oversized T-Shirt',
                'slug' => 'celestial-veil-oversized-t-shirt',
                'price' => 2009,
                'compare_price' => 2499,
                'is_featured' => true,
                'special_cats' => ['featured-collection'],
                'images' => ['https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=880&q=80'],
            ],
        ];

        foreach ($productsData as $data) {
            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'product_type' => 'simple',
                    'status' => 'active',
                    'is_featured' => $data['is_featured'] ?? false,
                    'is_new' => $data['is_new'] ?? false,
                    'is_bestseller' => $data['is_bestseller'] ?? false,
                    'short_description' => 'Premium quality apparel with modern design.',
                    'description' => 'Experience style and comfort with our latest collection. Crafted with premium fabrics for a perfect fit.',
                    'main_category_id' => $mainCategoryIds[1], // T-Shirts as default main category
                ]
            );

            // Link to special categories
            if (isset($data['special_cats'])) {
                $syncIds = [];
                foreach ($data['special_cats'] as $catSlug) {
                    if (isset($specialCategoryIds[$catSlug])) {
                        $syncIds[] = $specialCategoryIds[$catSlug];
                    }
                }
                $product->categories()->syncWithoutDetaching($syncIds);
            }

            $variant = ProductVariant::updateOrCreate(
                ['product_id' => $product->id, 'is_default' => true],
                [
                    'sku' => strtoupper(substr($data['slug'], 0, 3)) . '-' . strtoupper(Str::random(5)),
                    'price' => $data['price'],
                    'compare_price' => $data['compare_price'] ?? null,
                    'stock_quantity' => 100,
                    'stock_status' => 'in_stock',
                    'status' => true,
                ]
            );

            // Attach images to variant
            $images = $data['images'] ?? $defaultProductImages;
            foreach ($images as $index => $url) {
                $media = Media::firstOrCreate(
                    ['file_path' => $url],
                    [
                        'file_name' => basename(parse_url($url, PHP_URL_PATH)),
                        'disk' => 'url',
                        'mime_type' => 'image/jpeg',
                        'file_type' => 'image',
                        'alt_text' => $data['name'] . ' View ' . ($index + 1),
                    ]
                );

                $variant->images()->syncWithoutDetaching([
                    $media->id => [
                        'is_primary' => $index === 0,
                        'sort_order' => $index,
                    ]
                ]);
            }
        }


        // 4. Create Banners
        Banner::create([
            'title' => 'Fashion Collection',
            'subtitle' => 'Discover the latest trends in luxury fashion.',
            'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80',
            'cta_text' => 'Shop Now',
            'cta_link' => '/products',
            'sort_order' => 1,
            'status' => true,
        ]);

        Banner::create([
            'title' => 'Casual Style',
            'subtitle' => 'Minimalist designs for everyday comfort.',
            'image' => 'https://marketplace.canva.com/EAFT4iBtkRY/1/0/800w/canva-beige-brown-minimalist-casual-style-banner-landscape-nCTDUarPDJo.jpg',
            'cta_text' => 'Explore',
            'cta_link' => '/products',
            'sort_order' => 2,
            'status' => true,
        ]);

        // 5. Create Home Sections (Connected to special categories)
        HomeSection::updateOrCreate(
            ['title' => 'Featured Collection'],
            [
                'subtitle' => 'Handpicked favorites for you',
                'type' => 'category',
                'category_id' => $specialCategoryIds['featured-collection'],
                'style' => 'style_1',
                'sort_order' => 1,
                'status' => true,
            ]
        );

        HomeSection::updateOrCreate(
            ['title' => 'New Arrivals'],
            [
                'subtitle' => 'Fresh styles just landed',
                'type' => 'category',
                'category_id' => $specialCategoryIds['new-arrivals-home'],
                'style' => 'style_2',
                'sort_order' => 2,
                'status' => true,
            ]
        );

        HomeSection::updateOrCreate(
            ['title' => 'Best Sellers'],
            [
                'subtitle' => 'Most loved products',
                'type' => 'category',
                'category_id' => $specialCategoryIds['best-sellers-home'],
                'style' => 'style_3',
                'sort_order' => 3,
                'status' => true,
            ]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
