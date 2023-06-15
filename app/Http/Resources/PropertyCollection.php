<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/** @mixin \App\Models\Property  */
class PropertyCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'property_name' => $this->property_name,
            'property_address' => $this->property_address,
            'property_price' => $this->property_price,
            'property_stock' => $this->property_stock == 0 ? 'Property Unavailable' : $this->property_stock,
            'category_id' => $this->category_id,
            'property_description' => $this->property_description,
            'property_total_floor_area' => $this->property_total_floor_area,
            'property_bedroom_number' => $this->property_bedroom_number == 0 ? 'No Bedroom' : $this->property_bedroom_number,
            'property_toilet_number' => $this->property_toilet_number == 0 ? 'No Toilet' : $this->property_toilet_number,
            'user_id' => $this->user_id,
        ];
    }
}
