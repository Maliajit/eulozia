<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
use App\Models\Specification;
use App\Models\SpecificationGroup;
use App\Models\SpecificationValue;
use App\Models\ProductSpecification;
use App\Models\CategorySpecGroup;
use App\Models\SpecGroupSpec;
use App\Models\CategoryAttribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductAttributeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Size Attribute
        $sizeAttribute = Attribute::updateOrCreate(
            ['code' => 'size'],
            [
                'name' => 'Size',
                'type' => 'text',
                'is_variant' => true,
                'is_filterable' => true,
                'status' => true,
                'sort_order' => 1
            ]
        );

        $sizes = [
            ['value' => 'S-38', 'label' => 'S-38'],
            ['value' => 'M-40', 'label' => 'M-40'],
            ['value' => 'L-42', 'label' => 'L-42'],
            ['value' => 'XL-44', 'label' => 'XL-44'],
        ];

        $sizeValueIds = [];
        foreach ($sizes as $index => $sizeData) {
            $value = AttributeValue::updateOrCreate(
                ['attribute_id' => $sizeAttribute->id, 'value' => $sizeData['value']],
                [
                    'label' => $sizeData['label'],
                    'status' => true,
                    'sort_order' => $index + 1
                ]
            );
            $sizeValueIds[] = $value->id;
        }

        // 2. Create Color Attribute
        $colorAttribute = Attribute::updateOrCreate(
            ['code' => 'color'],
            [
                'name' => 'Color',
                'type' => 'color',
                'is_variant' => true,
                'is_filterable' => true,
                'status' => true,
                'sort_order' => 2
            ]
        );

        $colors = [
            ['value' => 'White', 'label' => '#FFFFFF'],
            ['value' => 'Black', 'label' => '#000000'],
            ['value' => 'Navy Blue', 'label' => '#000080'],
            ['value' => 'Maroon', 'label' => '#800000'],
        ];

        $colorValueIds = [];
        foreach ($colors as $index => $colorData) {
            $value = AttributeValue::updateOrCreate(
                ['attribute_id' => $colorAttribute->id, 'value' => $colorData['value']],
                [
                    'label' => $colorData['label'],
                    'status' => true,
                    'sort_order' => $index + 1
                ]
            );
            $colorValueIds[] = $value->id;
        }

        // 3. Create Specification Groups
        $styleGroup = SpecificationGroup::updateOrCreate(
            ['name' => 'Fabric & Style'],
            ['status' => true, 'sort_order' => 1]
        );

        // 4. Create Specifications
        $specs = [
            ['name' => 'Material', 'code' => 'material', 'input_type' => 'select'],
            ['name' => 'Pattern', 'code' => 'pattern', 'input_type' => 'select'],
            ['name' => 'Sleeve', 'code' => 'sleeve', 'input_type' => 'select'],
            ['name' => 'Fit', 'code' => 'fit', 'input_type' => 'select'],
            ['name' => 'Collar', 'code' => 'collar', 'input_type' => 'select'],
        ];

        $specIds = [];
        foreach ($specs as $index => $specData) {
            $spec = Specification::updateOrCreate(
                ['code' => $specData['code']],
                [
                    'name' => $specData['name'],
                    'input_type' => $specData['input_type'],
                    'is_filterable' => true,
                    'status' => true,
                    'sort_order' => $index + 1
                ]
            );
            $specIds[$specData['code']] = $spec->id;

            // Link to group
            SpecGroupSpec::updateOrCreate(
                ['spec_group_id' => $styleGroup->id, 'specification_id' => $spec->id],
                ['sort_order' => $index + 1]
            );
        }

        // 5. Create Specification Values
        $specValues = [
            'material' => ['100% Cotton', 'Polycotton', 'Linen'],
            'pattern' => ['Solid', 'Checkered', 'Striped', 'Printed'],
            'sleeve' => ['Full Sleeve', 'Half Sleeve'],
            'fit' => ['Slim Fit', 'Regular Fit', 'Tailored Fit'],
            'collar' => ['Spread Collar', 'Button-Down Collar', 'Mandarin Collar'],
        ];

        $specValueIds = [];
        foreach ($specValues as $code => $values) {
            foreach ($values as $index => $val) {
                $value = SpecificationValue::updateOrCreate(
                    ['specification_id' => $specIds[$code], 'value' => $val],
                    ['status' => true, 'sort_order' => $index + 1]
                );
                $specValueIds[$code][] = $value->id;
            }
        }

        // 6. Update Demo Products
        $productNames = [
            'A LUXURY HI FASHION DOUBLE POCKET CLUB SHIRT',
            'CHECKERED FORMAL SHIRT'
        ];

        foreach ($productNames as $name) {
            $product = Product::where('name', $name)->first();
            if (!$product)
                continue;

            $product->update(['product_type' => 'configurable']);
            $categoryId = $product->main_category_id;

            // Link Attributes to Category
            CategoryAttribute::updateOrCreate(
                ['category_id' => $categoryId, 'attribute_id' => $sizeAttribute->id],
                ['sort_order' => 1]
            );
            CategoryAttribute::updateOrCreate(
                ['category_id' => $categoryId, 'attribute_id' => $colorAttribute->id],
                ['sort_order' => 2]
            );

            // Link Group to Category
            CategorySpecGroup::updateOrCreate(
                ['category_id' => $categoryId, 'spec_group_id' => $styleGroup->id],
                ['sort_order' => 1]
            );

            // Delete old variants
            $product->variants()->delete();

            // Create new variants (Size x Color)
            // Limit combinations to keep it manageable
            $selectedSizes = array_slice($sizeValueIds, 0, 3); // S, M, L
            $selectedColors = array_slice($colorValueIds, 0, 2); // White, Black

            $isFirst = true;
            foreach ($selectedSizes as $sId) {
                foreach ($selectedColors as $cId) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(Str::random(10)),
                        'price' => 2239,
                        'compare_price' => 2799,
                        'stock_quantity' => rand(10, 50),
                        'stock_status' => 'in_stock',
                        'is_default' => $isFirst,
                        'status' => true
                    ]);

                    VariantAttribute::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $sizeAttribute->id,
                        'attribute_value_id' => $sId
                    ]);

                    VariantAttribute::create([
                        'variant_id' => $variant->id,
                        'attribute_id' => $colorAttribute->id,
                        'attribute_value_id' => $cId
                    ]);

                    $isFirst = false;
                }
            }

            // Assign Specifications to Product
            foreach ($specIds as $code => $id) {
                ProductSpecification::updateOrCreate(
                    ['product_id' => $product->id, 'specification_id' => $id],
                    ['specification_value_id' => $specValueIds[$code][0]] // Assign first value as default
                );
            }
        }
    }
}
