<?php

namespace App\Http\Services;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanServices {

    public function getLoans()
    {
        return Loan::with('customer','loanType')->where('status', '!=', 'void')->get();
    }

    public function getLoan(Loan $loan)
    {  
        return Loan::with('customer','loanType', 'payments')->where('id', $loan->id)->first();
    }

    public function getLoanByCustomer($id)
    {
        return Loan::with('customer','loanType')->where('customer_id',$id)->first();
    }

 

    public function store(Request $request)
    {
        $validated = $request->validated();
        $loan  = Loan::ExistingLoan($validated['customer_id']);       
        if($loan != null) return response()->json(['status' => 500, 'message' => 'This Customer has an exist loan' ]);   
        $validated['status'] = 'approved';
        $validated['user_id'] = $request->user()->id;
        $validated['balance_amount'] = $validated['total_amount'];
        return Loan::create($validated);
    }   

}