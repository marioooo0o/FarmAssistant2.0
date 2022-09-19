<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'ppp_id' => 'required|exists:plant_protection_products,id|',
            'quantity' => 'required|numeric|min:0',
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
            'ppp_id.required' => 'Produkt jest wymagany',
            'ppp_id.exists' => 'Produkt musi zawerać się w bazie',
            'quantity.required' => 'Wartość jest wymagana',
            'quantity.numeric' => 'Wartość powinna być liczbą',
            'quantity.min' => 'Wartość musi być większa od 0'
        ];
    }
}
