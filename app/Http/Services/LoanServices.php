<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Models\PaymentDueDate;
use App\Http\Resources\LoanResource;

class LoanServices extends BaseServices {

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

    
    public function getLoans($type = null, $filter = null, $sort = null, $order = null)
    {
      
        $loans = Loan::with('borrower')
                ->when(!is_null($type), function ($query) use ($type) {
                    $query->where('type', $type);
                })
                ->when(!is_null($filter), function ($query) use ($filter) {
                    if ($filter == 'all') return;
                    $query->where('status', $filter);
                })
                ->when(!is_null($sort) && ! is_null($order), function ($query) use ($sort, $order) {
                    if ($sort == 'name') {
                        $query->orderBy(Borrower::select('lastname')
                              ->whereColumn('borrowers.id', 'loans.id'),
                                $order
                        );
                        return;
                    }
                    $query->orderBy($sort, $order);
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->perpage);

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

        $validated['status'] = Loan::$PENDING;

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

    public function search($keyword, $type = null) 
    {
        $loans = Loan::when($type != null, function($q) use ($type) {
                        $q->where('type', $type);
                })  
                ->Search($keyword, $type)
                ->paginate($this->perpage);
                
        return LoanResource::collection($loans);
    }


   



}