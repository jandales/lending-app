<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowerRequest extends FormRequest
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
        $borrower_id = $this->id ?? '';

        $rules = [
            'firstname' => 'required',
            'lastname' => 'required', 
            'email' => 'required|unique:borrowers',        
            'address' => 'required',
            'phone' => 'required',
        ];

        if ($borrower_id != null) {
            $rules['email'] = 'required|unique:borrowers,email,' . $borrower_id;       
        }  

        return $rules;
        
    }
}
