<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanStoreRequest extends FormRequest
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
            'borrower_id' => 'required', 
            'terms' => 'required',
            'type' => 'required',
            'total_interest' => 'required',      
            'principal_amount' => 'required|numeric',
            'interest' => 'required',
            'effective_at' => 'required',  
            'total_amount' => 'required:numeric', 
            'collection_amount' => 'required:numeric', 
        ];
    }
}
