<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'type' => 'booking',
            'attributes' => [
                'name' => $this->name,
                'message' => $this->description,
                'email' => $this->email,
                // 'property' => $this->porperty->property_name,
                'sender' => $this->sender()->username
            ],

        ];
    }
}
