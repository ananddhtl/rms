<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuProductResource extends JsonResource
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
            'price' => $this->price,
            'description' => $this->description,
            'category_id' => (int)$this->category_id,
             'image_id' => (int)$this->image_id, 
            'image' => $this->whenLoaded('image', function () {
                return $this->image;
            }),
           
            'category' => $this->whenLoaded('category', function () {
                return $this->category;
            }),
          
            'category_image' => $this->whenLoaded('category.image', function () {
                return $this->category->image;
            }),
        ];
    }
}
