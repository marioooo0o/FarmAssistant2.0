<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'field_name' => 'required|string|max:100',
            'cadastral_parcels' => 'required|array',
            'cadastral_parcels.*.parcel_number' => 'required|integer|min:1|',
            'cadastral_parcels.*.area' => 'required|numeric|min:0',
            'crop' => 'required|exists:crops,name'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'field_name.required' => 'Nazwa pola jest wymagana',
            'cadastral_parcels.required' => 'Działki są wymagane',
            'crop.required' => 'Uprawa jest wymagana',
        ];
    }
}
