<?php

namespace App\Http\Services;

use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentServices
{
    private $status_paid = 'paid';
    private $status_void = 'void';
    private $status_released = 'released';
    private $current_date;
    
    public function __construct()
    {
        $this->current_date = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $payment = Payment::with('customer', 'loan')->orderBy('created_at', 'desc')->get();
        return PaymentResource::collection($payment);
    }

    public function store(Request $request)
    {
        $loan = Loan::findOrfail($request->loan_id);

        if ($loan->balance_amount <= 0 ) return response()->json(['status' => 500, 'message' => 'this transaction is already paid']);       
        if ($this->current_date < $loan->effective_at)  return response()->json(['status' => 500, 'message' => 'This Loan is not in due date']);            

        $validated = $request->validated(); 
        $validated['remark'] = $request->remark;
        $validated['user_id'] = $request->user()->id;
        $validated['status'] = $this->status_paid;                 
        
        $balance = $loan->balance_amount;

        if ($balance < (float)$validated['amount']) {
            $validated['amount'] = $balance;            
        } 

        $payment = Payment::create($validated);
        $balance -= (float)$validated['amount'];   
        Self::updateLoanBalance($loan,$balance); 

        return $payment;
    }

    public function view(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
        $loan  = Loan::findOrfail($payment->loan_id);
        $balance = $loan->balance_amount += $payment->amount;
        $loan = Self::updateLoanBalance($loan, $balance);      
        
        $payment->status = $this->status_void;        
        $payment->save();
        
        return new PaymentResource($payment);
    }

    private function updateLoanBalance(Loan $loan, $balance)
    {        
        $status = Loan::$STATUS_RELEASED;

        if ($balance == 0) {
            $status = Loan::$STATUS_PAID;
        }

        $loan->status = $status;
        $loan->balance_amount = $balance;        
        $loan->save();

        return $loan;
    }
}