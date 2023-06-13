<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'property_name'=> 'required|max:255|unique:proprties',
            'property_address'=>'required',
            'property_price'=>'required|float|max:10',
            'property_stock'=>'required|integer|max:5',
            'property_category'=>'required|max:255',
            'property_description'=>'required|max:255',
            'property_total_floor_area'=>'required|max:255',
            'property_bedroom_number'=>'required|max:3',
            'property_toilet_number'=>'required|max:3',
            'property_plan_image_url'=>'required|max:400;',
            'property_other_image_url'=>'required|max:400;',
            'owner_id'
        ];
    }
}
