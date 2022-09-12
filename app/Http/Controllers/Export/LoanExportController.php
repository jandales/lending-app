<?php

namespace App\Http\Controllers\Export;


use PDF;
use Illuminate\Http\Request;
use App\Http\Exports\LoanExport;
use App\Http\Reports\LoanReports;
use App\Http\Services\LoanServices;
use App\Http\Controllers\Controller;

class LoanExportController extends Controller
{
  

    private $report;

    private $services;

    public function __construct(LoanReports $report, LoanServices $services)
    {
        $this->report = $report;

        $this->services = $services;
    }

    public function index(Request $request)
    {   

        $export  = new LoanExport($request, $this->report);

        return $export->handleExport();

    }

    public function createPDF(Request $request)
    {
       
        $loans = $this->report->generate($request->start_date, $request->end_date); 
       
        view()->share(['loans' => $loans, 'start_date' => $request->start_date,  'end_date' => $request->end_date]);
        $pdf = PDF::loadView('loans', $loans->toArray())->setPaper('legal', 'landscape'); 
        return $pdf->output();
    }

    public function createLoanDetailPDF($id)
    {        
        $loan = $this->services->getLoan($id);  
        $pdf = PDF::loadView('loan-details', [ 'loan' => $loan]);
        return $pdf->output();
    }
}
