<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\PaymentDueDate;
use App\Http\Resources\LoanResource;

class LoanServices {

    private $PaymentTypes = [
        'daily' => 1,
        'weekly' => 7,
        '15days' => 15,
        'monthly' => 30,
    ];

    private function LoanNumber()
    {
        $id = Loan::max('id');    
        $timestamp = str_replace(['-'," ",":"],'', Carbon::now());
        return $timestamp . '' . $id;
    }

    
    public function getLoans()
    {

        $loans = Loan::with('borrower')->where('status', '!=', 'void')->orderBy('created_at', 'desc')->get();

        return LoanResource::collection($loans);

    }

    public function getLoan($id)
    {  

        $loan = Loan::with('borrower', 'payments', 'dueDates')->where('id', $id)->first();

        return new LoanResource($loan);

    }

    public function getLoanByCustomer($id)
    {

        $loan = Loan::with('borrower', 'payments')->where('borrower_id',$id)->first();

        return new LoanResource($loan);

    }

 

    public function store(Request $request)
    { 
      
        $validated = $request->validated();

        $exist  = Loan::ExistingLoan($validated['borrower_id']); 

        if ($exist) return response()->json(['status' => 500, 'message' => 'This Customer has an exist loan' ]);   

        $validated['loan_number'] = Self::LoanNumber();

        $validated['status'] = Loan::$STATUS_PENDING;

        $validated['user_id'] = $request->user()->id;

        $validated['balance_amount'] = $validated['total_amount'];
        
        $loan = Loan::create($validated);
      
        $due_date =  Self::createPaymentDueDate($loan, $loan->type);

        $loan->due_date_at = $due_date;

        $loan->save();

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
        
        return Loan::ExistingLoan($id);

    }

    public function createPaymentDueDate($loan, $payment_type)
    {
        
        $due_date = $loan->effective_at;      

        $days = (int)$this->PaymentTypes[$payment_type];

        $daysToPay = ((int)$loan->terms * 30) /  (int)$days;

        for ($i = 0; $i < $daysToPay; $i++) { 

            $due_date = Carbon::parse($due_date)->addDays($days);

            PaymentDueDate::create([

                'loan_id' => $loan->id,

                'due_date' => $due_date,

                'collection_amount' => $loan->collection_amount,

                'amount_paid' => 0,     

                'user_id' => $loan->user_id,

            ]);

        } 

        return $due_date;

        
    }


   



}