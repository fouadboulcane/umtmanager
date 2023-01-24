<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'placement' => ['nullable', 'max:20', 'string'],
            'client_id' => ['required', 'exists:clients,id'],
            'share_with' => ['required', 'in:only_me,all_members,few_members'],
            'color' => ['required'],
            'repeat' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
