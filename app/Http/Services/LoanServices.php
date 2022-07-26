<?php

namespace App\Http\Services;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanServices {

    public function getLoans()
    {
        return Loan::with('customer','loanType')->get();
    }

    public function getLoan(Loan $loan)
    {  
        return Loan::with('customer','loanType')->where('id', $loan->id)->first();
    }

    public function store(Request $request)
    {
        $validated = $request->validated();
        $loan  = Loan::ExistingLoan($validated['customer_id']);       
        if($loan != null) return response()->json(['status' => 500, 'message' => 'This Customer has an exist loan' ]);   
        $validated['status'] = 'approved';
        $validated['user_id'] = $request->user()->id;
        return Loan::create($validated);
    }   

}