<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFarmRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'street' => 'required|string|max:100',
            'street_number' => 'required|string',
            'postal_code' => 'required|string|regex:/^\d{2}-\d{3}$/',
            'city' => 'required|string|max:100'
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
            'name.required' => 'Nazwa jest wymagana',
            'street.required' => 'Ulica jest wymagana',
            'street_number.required' => 'Numer domu jest wymagany',
            'postal_code.required' => 'Kod pocztowy jest wymagany',
            'city.required' => 'Miejscowość jest wymagana',
            'postal_code.regex' => 'Kod pocztowy musi mieć format XX-XXX',
        ];
    }
}
