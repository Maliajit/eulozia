<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;
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

        // 2. Create Size Values
        $sizes = [
            ['value' => 'XS-36', 'label' => 'XS-36'],
            ['value' => 'S-38', 'label' => 'S-38'],
            ['value' => 'M-40', 'label' => 'M-40'],
            ['value' => 'L-42', 'label' => 'L-42'],
            ['value' => 'XL-44', 'label' => 'XL-44'],
            ['value' => 'XXL-46', 'label' => 'XXL-46'],
            ['value' => '3XL-48', 'label' => '3XL-48'],
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

        // 3. Update Demo Products to Configurable
        $productNames = [
            'A LUXURY HI FASHION DOUBLE POCKET CLUB SHIRT',
            'CHECKERED FORMAL SHIRT'
        ];

        foreach ($productNames as $name) {
            $product = Product::where('name', $name)->first();
            if (!$product) continue;

            $product->update(['product_type' => 'configurable']);

            // Delete existing variants except default or just create new ones
            // For safety, let's keep the existing logic and add variants
            
            $existingVariant = $product->variants()->where('is_default', true)->first();

            foreach ($sizeValueIds as $index => $valueId) {
                // If it's the first one, we can update the existing default variant
                if ($index === 0 && $existingVariant) {
                    $variant = $existingVariant;
                } else {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'sku' => strtoupper(Str::random(10)),
                        'price' => $existingVariant ? $existingVariant->price : 2239,
                        'compare_price' => $existingVariant ? $existingVariant->compare_price : 2799,
                        'stock_quantity' => rand(10, 50),
                        'stock_status' => 'in_stock',
                        'is_default' => false,
                        'status' => true
                    ]);
                }

                // Associate attribute value
                VariantAttribute::updateOrCreate(
                    [
                        'variant_id' => $variant->id,
                        'attribute_id' => $sizeAttribute->id,
                    ],
                    [
                        'attribute_value_id' => $valueId
                    ]
                );
            }
        }
    }
}
