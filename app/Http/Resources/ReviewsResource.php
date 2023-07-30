<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**   @mixin \App\Models\Reviews */
class ReviewsResource extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => strval($this->id),
            'type' => 'review',
            'attributes' => [
                'comment' => $this->comment,
                'rating' => $this->rating,
                'user_id' => $this->user_id,
                'property_id' => $this->property_id
            ]
            ];
        }
}