<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviRequestStoreRequest extends FormRequest
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
            'content' => ['nullable', 'max:255', 'json'],
            'manifest_id' => ['required', 'exists:manifests,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'in:pending,canceled,estimated,draft'],
        ];
    }
}
