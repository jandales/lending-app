<?php

namespace App\Http\Services;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanServices {

    public function getLoans()
    {
        return Loan::with('customer','loanType')->get();
    }

    public function store(Request $request)
    {
        return Loan::create([
            'customer_id' => $request->customer_id,
            'loan_type_id' => $request->loan_type_id,
            'amount' => $request->amount,
            'status' => 'approved',
            'user' => $request->user()->id,
        ]);
    }

}