<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
            'id' => strval($this?->id),
            'type' => 'favourite_product',
            'relationships' => [
                'user' => [
                    'id' => strval($this->user_id)
                ],
                'property' => [
                    'id' => strval($this->property_id)
                ]
            ]
        ]; 
    }
}
