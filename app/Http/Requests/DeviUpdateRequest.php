<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviUpdateRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'tax' => ['nullable', 'in:dt,tva_19%,tva_9%'],
            'tax2' => ['nullable', 'in:dt,tva_19%,tva_9%'],
            'note' => ['nullable', 'max:255', 'string'],
            'client_id' => ['required', 'exists:clients,id'],
        ];
    }
}
