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
       
        $validated = $request->validated(); 

        $loan = Loan::findOrfail($validated['loan_id']);             

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

        if ($loan->status == Loan::$STATUS_PAID) return;

        $balance = $loan->balance_amount += $payment->amount;

        Self::updateLoanBalance($loan, $balance); 
        
        Self::cancelDueDatePayment($payment->dueDate);
        
        $payment->status = $this->status_void;    

        $payment->save();       
        
        return new PaymentResource($payment);

    }

    
    private function updateLoanBalance(Loan $loan, $balance)
    {   

        if ($balance == 0) {

            $loan->status =  Loan::$STATUS_PAID;

        }        

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

    public function cancelDueDatePayment(PaymentDueDate $paymentDueDate)
    {

        $paymentDueDate->amount_paid = 0;

        $paymentDueDate->balance = 0;

        $paymentDueDate->paid_at = null;

        $paymentDueDate->status = null;

        $paymentDueDate->save();

    }

 
}