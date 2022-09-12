<?php

namespace App\Http\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Reports\BorrowersReport;


class BorrowerExport extends Export
{
   
    private $request;

    private $report;

    public function __construct(Request $request, BorrowersReport $report)
    {     
        $this->report = $report;

        $this->request = $request;      
    }

    public function handleExport()
    {   
      
        $borrowers = $this->report->generate($this->request->start_date, $this->request->end_date); 

        $data = array();   
        
        foreach($borrowers as $borrower)
        {             
           
            $item = $this->format($borrower);

            array_push($data, $item);

        }

        return $this->csv($this->columns(), $data);
        
    }

    public function format($borrower)
    {
        return [
            'id' => $borrower['id'],

            'name' => $borrower['name'],

            'email' =>$borrower['email'],

            'phone' => $borrower['phone'],

            'address' => $borrower['address'],                 

            'status' => $borrower['status'],

            'loans_sum_total_amount' => $borrower['loans_sum_total_amount'],

            'loans_count' => $borrower['loans_count'],    
        ];
    }
    
    public function columns() 
    {
        $columns = [ 

            'id',

            'Name',

            'Email',

            'Phone',

            'Address',          

            'Status',

            'Loan Total Amount',

            'Loan Count' ,           
        ];

        return $columns;
    }

    
}
