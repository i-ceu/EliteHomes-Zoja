<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/** @mixin \App\Models\User  */

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function __construct(Request $request)
    {
        $sender_id = $request->merge(['sender_id' => $request->user()?->id]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'required'],
            'email' => ['string', 'required'],
            'message' => ['string', 'required'],
            'phone_number' => ['string', 'required'],
            'property_id' => ['required', 'exists:properties,id'],
            'sender_id' => ['required', 'exists:users,id'],
        ];
    }
}
