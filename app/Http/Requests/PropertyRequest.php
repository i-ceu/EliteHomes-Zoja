<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/** @mixin \App\Models\User  */

class PropertyRequest extends FormRequest
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
        // $request->merge([
        //     'user_id' => $request->user()?->id,
        //     'property_other_image_url' => json_encode($request->property_other_image_url)
        // ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'property_name' => 'required|unique:properties',
            'property_address' => 'required',
            'property_price' => 'required|integer',
            'property_stock' => 'required|integer',
            'category_id' => 'required',
            'property_description' => 'required',
            'property_total_floor_area' => 'required',
            'property_bedroom_number' => 'required',
            'property_toilet_number' => 'required',
            'property_plan_image_url' => 'nullable|mimes:png,jpg,svg,jpeg,webp',
            'property_other_image_url.*' => 'nullable|mimes:png,jpg,svg,jpeg,webp',
            // 'user_id' => ['required']
            // "img"=>'required|mimes:png,jpg,svg,jpeg,webp'
        ];
    }
}
