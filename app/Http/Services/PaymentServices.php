<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\PaymentDueDate;
use App\Http\Resources\PaymentResource;

class PaymentServices extends BaseServices
{ 


    public function getPaymentAll($filter = null, $sort = null, $order = null)
    {

        $payment = Payment::with('borrower', 'loan')

                    ->when (!is_null($filter) , function($query) use ($filter) {
                        if ($filter == 'all') return;
                        $query->where('status', $filter);
                    })                          
                    ->when (!is_null($sort) && !is_null($order), function ($query) use($sort, $order) {

                        if ( $sort == 'lastname' ) {    
                            $query->orderBy(Borrower::select($sort)
                                ->whereColumn('borrowers.id', 'payments.id'),  
                                $order
                            );
                            return;
                        } 
                        $query->orderBy($sort, $order);
                    })
                    ->orderBy('created_at', 'desc')->paginate($this->perpage);

        return PaymentResource::collection($payment);

    }

    public function store(Request $request)
    {

        $validated = $request->validated();  
       
        $loan = Loan::findOrfail($validated['loan_id']);            

        $validated['remark'] = $request->remark;
        $validated['user_id'] = $request->user()->id;
        $validated['status'] = Payment::$PAID;  
        $validated['due_date'] = date("Y-m-d", strtotime($validated['due_date']));  

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

        if ($loan->status == Loan::$PAID) return;
        
        $balance = $loan->balance_amount += $payment->amount;
        Self::updateLoanBalance($loan, $balance);         
        Self::cancelDueDatePayment($payment->dueDate);        
        $payment->status = Payment::$VOID;    
        $payment->save();      
        return new PaymentResource($payment);

    }

    
    private function updateLoanBalance(Loan $loan, $balance)
    {   

        if ($balance === 0) {
            $loan->status =  Loan::$PAID;
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
        $data->status = Payment::$PAID;        
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

    public function search($keyword)
    {
     
        $payments = Payment::whereHas('borrower', function ($query) use ($keyword) {
                                $query->where('firstname', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('lastname', 'LIKE', '%' . $keyword . '%');
                            })  
                            ->orWhereHas('loan', function ($query) use ($keyword) {
                                $query->where('loan_number', 'LIKE', '%' . $keyword . '%');                            
                            })                 
                            ->orderBy('created_at', 'desc')->paginate($this->perpage);

        return PaymentResource::collection($payments);        
    }

 
}