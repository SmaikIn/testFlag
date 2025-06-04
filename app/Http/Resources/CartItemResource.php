<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CartItem */
class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'product_id' => $this->product_id,

            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
