<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ReserveTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'table_id' => $this->table_id,
            'date' => $this->date,
            'time' => $this->time,
            'guest_count' => $this->guest_count,
            'is_complete' => $this->is_complete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->whenLoaded('user', function () {
                return $this->user;
            }),
            'table' => $this->whenLoaded('table', function () {
                return $this->table;
            }),
        ];
    }
}
