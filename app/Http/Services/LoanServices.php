<?php

namespace App\Http\Services;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Resources\LoanResource;

class LoanServices {

    public function getLoans()
    {
        $loans = Loan::with('customer','loanType', 'payments')->where('status', '!=', 'void')->get();
        return LoanResource::collection($loans);
    }

    public function getLoan(Loan $loan)
    {  
        $loan = Loan::with('customer','loanType', 'payments')->where('id', $loan->id)->first();
        return new LoanResource($loan);
    }

    public function getLoanByCustomer($id)
    {
        $loan = Loan::with('customer','loanType')->where('customer_id',$id)->first();
        return new LoanResource($loan);
    }

 

    public function store(Request $request)
    {     
        
        $validated = $request->validated();
        $loan  = Loan::ExistingLoan($validated['customer_id']);       
        if($loan != null) return response()->json(['status' => 500, 'message' => 'This Customer has an exist loan' ]);   
        $validated['status'] = 'pending';
        $validated['user_id'] = $request->user()->id;
        $validated['total_amount'] = $validated['balance_amount'];
        $loan = Loan::create($validated);
        return new LoanResource($loan);
    } 
    
    public function updateStatus(Loan $loan, $status)
    {       
        $loan->status = $status;
        $loan->save();

        return new LoanResource(Self::getLoan($loan));
    }

    public function existLoan($id)
    {
        $loan  = Loan::ExistingLoan($id);
        if ($loan == null) return false;
        return true;
    }

}