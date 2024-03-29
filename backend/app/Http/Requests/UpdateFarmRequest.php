<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFarmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $farm = $this->route()->parameter('farms');

        return (auth()->user()->id == $farm->user_id);
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
            'postal_code' => 'required|string|size:5',
            'city' => 'required|string|max:100'
        ];
    }
}
