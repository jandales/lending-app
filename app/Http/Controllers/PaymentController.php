<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentStoreRequest;

class PaymentController extends Controller
{
    public function index()
    {
        return Payment::with('customer', 'loan')->where('status', 'paid')->get();
    }

    public function store(PaymentStoreRequest $request)
    {
        $loan = Loan::findOrfail($request->loan_id);

        if($loan->balance_amount === 0) return response()->json(['message' => 'this transaction is already paid']);

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
        return $payment;
    }

    public function destroy(Payment $payment)
    {
        $payment->status = 'void';
        $payment->save();
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
