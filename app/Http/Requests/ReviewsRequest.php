<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewsRequest1 extends FormRequest
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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'property_id' => 'required|exists:properties,id' ,
            'rating' => 'required|integer|min:1|max:5' ,
            'comment' => 'required|string|max:225' ,
        ];
    }
}
