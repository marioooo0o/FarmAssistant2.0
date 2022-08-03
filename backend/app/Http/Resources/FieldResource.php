<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'field_name' => $this->field_name,
            'cadastral_parcels' => CadastralParcelResource::collection($this->cadastralParcels),
            'crop' => $this->crop,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}