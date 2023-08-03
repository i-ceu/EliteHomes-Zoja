<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**   @mixin \App\Models\Booking */

class BookingResource extends JsonResource
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
            'name' => $this->name,
            'message' => $this->message,
            'email' => $this->email,
            'property_id' => $this->property?->id,
            'property_name' => $this->property?->property_name,
            'property_address' => $this->property?->property_address,
            'property_category' => $this->property?->category?->id,
            'property_description' => $this->property?->property_description,
            'property_other_image_url' => json_decode($this->property?->property_other_image_url),
            'propertyOwner' => $this->property?->user?->username,
            'sender' => $this->sender?->username


        ];
    }
}
