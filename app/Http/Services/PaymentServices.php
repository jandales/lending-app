<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use App\Helpers\Status;
use App\Models\Payment;
use App\Helpers\DueDate;
use App\Models\Borrower;
use App\Helpers\PaymentType;
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

    public function proccessPayment($data)
    {  
    
        $amount = (float)$data['amount'];   
    
        $loan = Loan::findOrfail($data['loan_id']); 
        $balance = $loan->balance_amount;
        
        if ($balance < $amount) {
            $amount['amount'] = $balance;   
        } 

        $data['status'] = STATUS::$PAID; 
        $payment = Payment::create($data);     
       
        $balance -= $amount; 
        $loan->updateBalance($balance); 
        
        $this->fundServices->setAmount($amount)->updateCurrentCapital();  

        $dueDate = DueDate::find($data['due_date_id'])->update($amount, $balance);   
        
        $result = DueDate::findByLoan($data['loan_id'])->isLastDate($data['due_date']);

        if ($result == true && $balance > 0) {
            self::handleAddMaturitiesDate($loan->id);
        }

        return $payment;

    }


    public function failedPayment(array $data)
    {  
        $id = $data['due_date_id'];        
        // create payment
        $data['status'] = STATUS::$FAILED; 
        Payment::create($data);
        // update due data info
        $dueDate = DueDate::find($id)->failedPayment(); 
        // add day in due date;        
        self::handleAddMaturitiesDate($dueDate->loan_id);
        return $dueDate;
    }

    private function handleAddMaturitiesDate($id)
    {
        $loan = Loan::find($id);
        $days = PaymentType::getValue($loan->type);        
        DueDate::findByLoan($id)->addDays($days); 
    }

 

    public function view(Payment $payment)
    {
        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {    
        $amount = $payment->amount;
        
        $loan  = Loan::findOrfail($payment->loan_id);
        
        $balance = $loan->balance_amount += $amount;
         
        DueDate::find($payment->dueDate->id)->void();       
        
        $loan->updateBalance($balance)->updateStatus(Status::$ACTIVE); 

        $this->fundServices->setAmount($amount)->updateCurrentCapital();

        $payment->status = Status::$VOID;
        $payment->save();  

        return new PaymentResource($payment);

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