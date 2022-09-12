<?php

namespace App\Http\Exports;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Reports\PaymentReports;


class PaymentExport extends Export
{
   
    private $request;

    private $report;

    public function __construct(Request $request, PaymentReports $report)
    {     
        $this->report = $report;

        $this->request = $request;      
    }

    public function handleExport()
    {   
      
        $payments = $this->report->generate($this->request->start_date, $this->request->end_date); 

        $data = array();   
        
        foreach($payments as $payment)
        {     
            $item = $this->format($payment);  

            array_push($data, $item);

        }
        
        return $this->csv($this->columns(), $data);

    }

    public function  format($payment)
    {
        return  [
            "id" => $payment['id'], 

            "loan_number" => $payment['loan']['loan_number'], 

            'borrower' => $payment['borrower'],

            "due_date" => $payment['due_date'],

            "amount" => $payment['amount'],  

            "paid_at" => $payment['paid_at'], 

            "status" => $payment['status'], 
        ];
    }

    public function columns() 
    {
        $columns = [ 

                "id", 

                "Loan Number", 

                'Borrower',

                "Due Date",
    
                "Amount",  
    
                "Paid_at", 

                "Status",          
        ];

        return $columns;
    }

    
}
