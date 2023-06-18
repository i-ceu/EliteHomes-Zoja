<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User  */

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  strval($this->id), // strval() converts the value of an object to a string (string value of an object)
            'username' => $this->username,
            'attributes' => [
                'firstName' =>  $this->first_name,
                'lastName' => $this->last_name,
                'fullName' => $this->first_name . ' ' . $this->last_name,
                'email' => $this->email,
                'profile_picture' => $this->getFirstMediaPath('avatars'),
                'phoneNumber' => $this->phone_number,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
        ];
    }
}
