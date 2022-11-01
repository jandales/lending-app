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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'due_date' => 'required',
            'payment_date' => 'required',
            'amount' => 'required|numeric',
            'borrower_id' => 'required',
            'loan_id' => 'required',
            'due_date_id' => 'required'          
        ];
    }
}
