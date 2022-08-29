<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CadastralParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'parcel_number' => $this->parcel_number,
        //     'parcel_area' => $this->parcel_area,
        //     'soil_Ph' => $this->soil_Ph,
        //     'area_in_field' => $this->whenPivotLoaded('cadastral_parcel_field', function () {
        //         return $this->pivot;
        //     }),
        //     // 'fields' => FieldResource::collection($this->fields),
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];
    }
}
