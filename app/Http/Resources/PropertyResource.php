<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/** @mixin \App\Models\Property  */

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

        return [
            "id" => strval($this->id),
            "type" => 'property',
            'user_id' => $this->user_id,
            'property_name' => $this->property_name,
            'property_address' => $this->property_address,
            'property_price' => $this->property_price,
            'property_stock' => $this->property_stock == 0 ? 'Property Unavailable' : $this->property_stock,
            'category_id' => $this->category_id,
            'property_description' => $this->property_description,
            'property_total_floor_area' => $this->property_total_floor_area,
            'property_bedroom_number' => $this->property_bedroom_number,
            'property_toilet_number' => $this->property_toilet_number,
            'property_plan_image_url' => $this->getFirstMediaPath('floor_plans'),
            'property_other_image_url' => $this->getMedia('propertyPictures')->map(function (Media $media) {
                return $media->getPath();
            })->toArray(),
            'property_owner' => [
                'user_id' => $this->user_id,
                'full_name' => $this->user->first_name . ' ' . $this->user->last_name,
                'phone_number' => $this->user->phone_number,
                'email' => $this->user->email,
                'profile_picture' => $this->user->profile_picture,
            ]
        ];
    }
}
