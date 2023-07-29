<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * 
     */
    public function authorize():bool
    {
        return true;

    }
    public function __construct(Request $request)
    {
        $user_id = $request->merge(['user_id' => $request->user()?->id]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:225',
            'last_name' => 'required|string|max:225',
            'user_id' => 'required|exists:users,id' ,
            'property_id' => 'required|exists:properties,id' ,
            'profile_picture' => 'nullable|mimes:png,jpg,svg,jpeg,webp',
            'rating' => 'required|integer|min:1|max:5' ,
            'comment' => 'required|string|max:225' ,
        ];
    }
}
