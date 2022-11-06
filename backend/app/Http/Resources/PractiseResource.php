<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PractiseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'farm_id' => $this->farm_id,
            'name' => $this->name,
            'water' => $this->water,
            'start' => $this->start,
            'fields' => FieldResource::collection($this->fields),
            'plant_protection_products' => $this->plantProtectionProducts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
