<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'street' => $this->street,
            'street_number' => $this->street_number,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'area' => $this->area,
            'warehouse' => $this->warehouse,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
