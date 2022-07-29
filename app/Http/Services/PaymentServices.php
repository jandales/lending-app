<?php

namespace App\Http\Services;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentServices
{
    public function index()
    {
        $payment = Payment::with('customer', 'loan')->where('status', 'paid')->get();
        return PaymentResource::collection($payment);
    }

    public function store(Request $request)
    {
       
        $loan = Loan::findOrfail($request->loan_id);
      
        $current_date = date('Y-m-d H:i:s');

        if ($current_date < $loan->effective_at) return response()->json(['status' => 500, 'message' => 'This Loan is not in due date']);            
      
        if($loan->balance_amount === 0) return response()->json(['status' => 500, 'message' => 'this transaction is already paid']);

        $validated =$request->validated();
        $validated['remark'] = $request->remark;
        $validated['user_id'] = $request->user()->id;
        $validated['status'] = 'paid';
        $payment = Payment::create($validated);
        
        Self::updateLoanBalance($loan, $validated['amount']); 

        return $payment;
    }

    public function view(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
        $loan  = Loan::findOrfail($payment->id);
        $loan->balance_amount += $payment->amount;
        $loan->save();
        
        $payment->status = 'void';        
        $payment->save();
        
        return new PaymentResource($payment);
    }

    private function updateLoanBalance(Loan $loan, $amount)
    {       
     
        $balance = (float)$loan->balance_amount - (float)$amount;

        if ($balance == 0) {
            $loan->status = 'paid';
        }

        $loan->balance_amount = $balance;
        $loan->save();

        return $loan;
    }
}