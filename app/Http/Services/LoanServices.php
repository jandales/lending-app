<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Models\Loan;
use App\Helpers\Status;
use App\Models\Capital;
use App\Helpers\DueDate;
use Illuminate\Http\Request;
use App\Models\PaymentDueDate;
use App\Http\Services\FundServices;
use App\Http\Resources\LoanResource;
use App\Http\Services\BorrowerServices;

class LoanServices extends BaseServices {





    private FundServices $fundServices;

    public function __construct(FundServices $fundServices)
    {
        $this->fundServices = $fundServices;
    }

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

    public function store(array $request, $user_id)
    { 
        // check if borrower has an active loan
        $exist  = Self::existLoan($request['borrower_id']); 

        if ($exist) {
            return response()->json(['errors' => [ 'message' => 'This borrower has an exist loan' ]], 422);
        }

        $pricipal_amount = (double)$request['principal_amount']; 

        $result = $this->fundServices->setAmount($pricipal_amount)->hasFunds();

        if ($result === false) {
            return response()->json(['errors' => ['message' => 'You dont have enough funds'] ], 422);
        }      

        $request['loan_number'] = Self::LoanNumber();
        $request['status'] = Status::$PENDING;
        $request['user_id'] = $user_id;
        $request['balance_amount'] = $request['total_amount'];                        
        $loan = Loan::create($request);       

        $this->fundServices->setAmount($pricipal_amount)->isDeduction()->updateCurrentCapital();

        return new LoanResource($loan);        

    } 
    
    public function updateStatus(Loan $loan, $status, $user_id)
    {   
        if (Status::$REJECTED  == $status) {
            return Self::reject($loan); 
        }   

        if (Status::$VOID == $status) {
            return Self::void($loan);         
        }

        if (Status::$ACTIVE == $status) {           
            $due_date = DueDate::create($loan, $user_id);
            BorrowerServices::updateLoanStatus($loan->borrower_id, 1);
        }
        
        $loan->status = $status;         
        $loan->save(); 

        return new LoanResource(Self::getLoan($loan));
    }

    public function existLoan($id)
    {
        return Loan::ExistingLoan($id);
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

    public function reject(Loan $loan)
    {
        $loan->status = Status::$REJECTED;

        if (!$loan->save()) return;    
        
        BorrowerServices::updateLoanStatus($loan->borrower_id, 0);

        $this->fundServices
            ->setAmount($loan->principal_amount)    
            ->updateCurrentCapital();

        return $loan;  

    }

    public function void(Loan $loan)
    {   
        if (Status::$REJECTED == $loan->status || Status::$VOID == $loan->status) return $loan;

        $loan->status = Status::$VOID;
        $loan->save(); 

        BorrowerServices::updateLoanStatus($loan->borrower_id, 0);
          
        return $loan;
    }


    

    





   



}