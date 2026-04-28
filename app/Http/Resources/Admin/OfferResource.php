<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'status' => $this->status,
            'offer_type' => $this->offer_type,
            'discount_value' => $this->discount_value,
            'buy_qty' => $this->buy_qty,
            'get_qty' => $this->get_qty,
            'min_cart_amount' => $this->min_cart_amount,
            'max_cart_amount' => $this->max_cart_amount,
            'max_discount' => $this->max_discount,
            'max_uses' => $this->max_uses,
            'uses_per_customer' => $this->uses_per_customer,
            'used_count' => $this->used_count,
            'starts_at' => $this->starts_at?->format('Y-m-d H:i:s'),
            'ends_at' => $this->ends_at?->format('Y-m-d H:i:s'),
            'is_auto_apply' => $this->is_auto_apply,
            'is_stackable' => $this->is_stackable,
            'is_exclusive' => $this->is_exclusive,
            'customer_segment_id' => $this->customer_segment_id,
            'categories' => $this->whenLoaded('categories', function() {
                return $this->categories->map(function($cat) {
                    return [
                        'id' => $cat->id,
                        'name' => $cat->name
                    ];
                });
            }),
            'variants' => $this->whenLoaded('variants', function() {
                return $this->variants->map(function($variant) {
                    return [
                        'id' => $variant->id,
                        'product_id' => $variant->product_id,
                        'product_name' => $variant->product?->name,
                        'sku' => $variant->sku
                    ];
                });
            }),
            'rewards' => $this->whenLoaded('rewards', function() {
                return $this->rewards->map(function($reward) {
                    return [
                        'id' => $reward->id,
                        'reward_product_id' => $reward->reward_product_id,
                        'reward_product_name' => $reward->product?->name,
                        'reward_variant_id' => $reward->reward_variant_id,
                        'reward_qty' => $reward->reward_qty
                    ];
                });
            }),
            'is_active' => $this->isActive(),
            'offer_type_text' => $this->getOfferTypeText(),
            'starts_at_formatted' => $this->starts_at?->format('M d, Y H:i'),
            'ends_at_formatted' => $this->ends_at?->format('M d, Y H:i'),
            'created_at_formatted' => $this->created_at?->format('M d, Y'),
            'days_remaining' => $this->getDaysRemaining(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
