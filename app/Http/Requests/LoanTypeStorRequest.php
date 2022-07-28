<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanTypeStorRequest extends FormRequest
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
            'type' => 'required',           
            'interest' => 'required:numeric',
            'amount_to_pay' => 'required:numeric',
            'due_type' => 'required:numeric'           
        ];
    }
}