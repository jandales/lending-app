<?php

namespace App\Http\Controllers\Export;


use Illuminate\Http\Request;
use App\Http\Exports\LoanExport;
use App\Http\Reports\LoanReports;
use App\Http\Controllers\Controller;

class LoanExportController extends Controller
{
  

    private $report;

    public function __construct(LoanReports $report)
    {
        $this->report = $report;
    }

    public function index(Request $request)
    {   

        $export  = new LoanExport($request, $this->report);

        return $export->handleExport();

    }
}
