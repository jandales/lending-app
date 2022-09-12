<?php

namespace App\Http\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Reports\LoanReports;

class LoanExport extends Export
{
   
    private $request;

    private $report;

    public function __construct(Request $request, LoanReports $report)
    {     
        $this->report = $report;

        $this->request = $request;      
    }

    public function handleExport()
    {   
      
        $loans = $this->report->generate($this->request->start_date, $this->request->end_date); 
        
        $data = array();

        foreach($loans as $loan)
        {  
            $item = $this->format($loan);

            array_push($data, $item);
        }  

        return $this->csv($this->columns(), $data);

    }

    public function format($loan)
    {
        return [  
            'loan_number' => $loan->loan_number, 
            'borrower' => $loan->borrower->firstname . " " . $loan->borrower->lastname,                   
            'terms' => $loan->terms . " ". "Months" ,
            'type' => $loan->type,
            'interest' => $loan->interest,
            'principal_amount' => $loan->principal_amount,                              
            'total_interest' => $loan->total_interest,
            'collection_amount' => $loan->collection_amount,
            'total_amount' => $loan->total_amount,  
            'balance_amount' => $loan->balance_amount,
            'status' => $loan->status,
            'effective_at' => Carbon::parse($loan->effective_at)->format('Y-m-d'),
            'due_date_at' => $loan->due_date_at != null ? Carbon::parse($loan->due_date_at)->format('Y-m-d') : null,
            'release_date' => $loan->updated_at->format('Y-m-d'),                 
        ];
    }

    public function columns(){

        return [          
            'Loan Number',
            'Borrower', 
            'Payment Terms',
            'Payemnt Type',
            'Interest',
            'Principal Amount',
            'Total Interest',
            'Collection Amount',
            'Total Amount',
            'Balance Amount',  
            'Status' ,
            'Effective_at', 
            'Due Date',  
            'Release Date'
        ];
    }

    
}
