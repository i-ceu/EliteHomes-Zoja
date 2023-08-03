<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
/** @mixin \App\Models\Favourite */

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => strval($this->id),
            'property_name' => $this->property_name,
            'property_address' => $this->property_address,
            'category_id' => $this->category_id,
            'property_description' => $this->property_description,
            'property_other_image_url' => json_decode($this->property_other_image_url)
        ];
    }
}
