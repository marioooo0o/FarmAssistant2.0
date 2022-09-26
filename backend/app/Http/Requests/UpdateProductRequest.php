<?php

namespace App\Http\Requests;

use App\Models\Farm;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $farmId = $this->route()->parameter('farm_id');
        return Gate::allows('update-product-in-magazine', Farm::findOrFail($farmId));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
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
            'quantity.required' => 'Wartość jest wymagana',
            'quantity.numeric' => 'Wartość powinna być liczbą',
            'quantity.min' => 'Wartość musi być większa od 0'
        ];
    }
}
