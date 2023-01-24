<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseUpdateRequest extends FormRequest
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
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
            'category' => ['required', 'in:miscellaneous_expense'],
            'tax' => ['required', 'in:dt,tva_19%,tva_9%'],
            'tax2' => ['required', 'in:dt,tva_19%,tva_9%'],
            'project_id' => ['required', 'exists:projects,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
