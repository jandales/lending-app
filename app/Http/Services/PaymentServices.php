<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\PaymentDueDate;
use App\Http\Resources\PaymentResource;

class PaymentServices
{
    private $status_paid = 'paid';
    private $status_void = 'void';
    private $status_released = 'released';
    private $status_failed = 'failed';
    private $current_date;
    
    public function __construct()
    {
        $this->current_date = date('Y-m-d H:i:s');
    }

    public function index()
    {
        $payment = Payment::with('borrower', 'loan')->orderBy('created_at', 'desc')->get();

        return PaymentResource::collection($payment);
    }

    public function store(Request $request)
    {
        $loan = Loan::findOrfail($request->loan_id);      

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

        Self::updateDueDate($request->due_date_id, $validated['amount'], $balance);

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

        Self::updateLoanBalance($loan, $balance);      
        
        $payment->status = $this->status_void;    

        $payment->save();
        
        return new PaymentResource($payment);
    }

    public function failedToPay($id)
    {
        $dueDate = PaymentDueDate::find($id);

        $dueDate->status = $this->status_failed;

        $dueDate->save();
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

    public function updateDueDate($id, $amount, $balance)
    {
       
        $data = PaymentDueDate::find($id);

        $data->paid_at = now();

        $data->amount_paid = $amount;

        $data->balance = $balance;

        $data->status = $this->status_paid;
        
        $data->save();
    }
}