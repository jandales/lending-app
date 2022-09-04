<?php

namespace App\Http\Controllers\Export;

use App\Http\Traits\Export;
use Illuminate\Http\Request;
use App\Http\Reports\LoanReports;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;

class LoanExportController extends Controller
{
    use Export;

    private $report;

    public function __construct(LoanReports $report)
    {
        $this->report = $report;
    }

    public function index(Request $request)
    {
      
        $loans = $this->report->generate($request->start_date, $request->end_date);
        
        // $loans = LoanResource::collection($loans);

        $columns = [
            'id',
            'loan_number',
            'terms',
            'type',
            'principal_amount',
            'total_amount',
            'balance_amount',
            'total_interest',
            'collection_amount',
            'interest',
            'status' ,
            'effective_at',
            'created_at', 
            'borrower',                  
            'payments' ,
            'due_dates',
        ];




         return $this->csv($columns);


    }
}
