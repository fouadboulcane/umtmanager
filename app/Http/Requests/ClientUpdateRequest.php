<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'address' => ['required', 'max:255', 'string'],
            'city' => ['required', 'max:255', 'string'],
            'state' => ['required', 'max:255', 'string'],
            'zipcode' => ['required', 'max:255'],
            'website' => ['nullable', 'max:255', 'string'],
            'tva_number' => ['required', 'max:255', 'string'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'rc' => ['required', 'max:255', 'string'],
            'nif' => ['required', 'max:255', 'string'],
            'art' => ['required', 'max:255', 'string'],
            'online_payment' => ['required', 'boolean'],
        ];
    }
}
