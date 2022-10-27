<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use App\Helpers\Status;
use App\Models\Payment;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Models\PaymentDueDate;
use App\Http\Resources\PaymentResource;

class PaymentServices extends BaseServices
{ 
    private FundServices $fundServices;

    public function __construct(FundServices $fundServices)
    {
        $this->fundServices = $fundServices;
    }

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

    public function store(array $request, $user_id)
    {    
        $amount = (float)$request['amount'];

        $loan = Loan::findOrfail($request['loan_id']); 
    
        $request['user_id'] = $user_id;
        $request['status'] = STATUS::$PAID;  
        $request['due_date'] = date("Y-m-d", strtotime($request['due_date'])); 

        $balance = $loan->balance_amount;
        
        if ($balance < $amount) {
            $request['amount'] = $balance;   
        } 

        $payment = Payment::create($request);      
       
        $balance -= $amount; 

        $loan->updateBalance($balance); 

        $this->fundServices->setAmount($amount)->updateCurrentCapital();

        Self::updateDueDate($request['due_date_id'], $amount, $balance);

        return $payment;

    }

    public function view(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {    
        $amount = $payment->amount;
        
        $loan  = Loan::findOrfail($payment->loan_id);

        if ($loan->status == STATUS::$PAID) return;
        
        $balance = $loan->balance_amount += $amount;
             
        Self::cancelDueDatePayment($payment->dueDate);  
        
        Self::updateLoanBalance($loan, $balance);  

        $this->fundServices->setAmount($amount)->updateCurrentCapital();

        $payment->status = Status::$VOID;  

        $payment->save();  

        return new PaymentResource($payment);

    }

    
    private function updateLoanBalance(Loan $loan, $balance)
    {   

        if ($balance ===  0 || $balance < 0) {
            $loan->status = Status::$PAID;
        }       

        $loan->balance_amount = $balance;  
        $loan->save();

        return $loan;

    }

    public function updateDueDate($id, $amount, $balance)
    {  
        $balance = $balance < $amount ? 0 : $balance;
        $date = PaymentDueDate::find($id);
        $date->paid_at = now();
        $date->amount_paid = $amount;
        $date->balance = $balance;
        $date->status = Payment::$PAID;        
        $date->save();
    }

    public function cancelDueDatePayment(PaymentDueDate $paymentDueDate)
    {
        $paymentDueDate->amount_paid = 0;
        $paymentDueDate->balance = 0;
        $paymentDueDate->paid_at = null;
        $paymentDueDate->status = Status::$VOID;
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