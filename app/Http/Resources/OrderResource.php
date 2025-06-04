<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Order */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user_id' => $this->user_id,
            'order_payment_type_id' => $this->order_payment_type_id,
            'order_status_id' => $this->order_status_id,

            'orderPaymentType' => new OrderPaymentTypeResource($this->whenLoaded('orderPaymentType')),
            'orderStatus' => new OrderStatusResource($this->whenLoaded('orderStatus')),
        ];
    }
}
