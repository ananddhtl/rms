<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'user_id' => (int)$this->user_id,
            'cart_total' => $this->cart_total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'items_count' => $this->items_count,
            'items' => CartItemsResource::collection($this->items), // Assuming you also have a CartItemResource
        ];
    }
}
