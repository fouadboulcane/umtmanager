<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'note' => ['nullable', 'max:255', 'string'],
            'mode' => [
                'required',
                'in:cash,postal_check,bank_check,bank_transfer',
            ],
            'invoice_id' => ['required', 'exists:invoices,id'],
        ];
    }
}
