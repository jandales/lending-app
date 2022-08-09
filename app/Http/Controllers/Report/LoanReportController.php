<?php

namespace App\Http\Controllers\Report;


use Illuminate\Http\Request;
use App\Http\Reports\LoanReports;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Http\Requests\ReportDateRequest;

class LoanReportController extends Controller
{
    private $report;

    public function __construct(LoanReports $report)
    {

        $this->report = $report;

    }

    public function index(ReportDateRequest $request)
    {  

        $loans =  $this->report->generate($request->start_date, $request->end_date);
        
        return LoanResource::collection($loans);

    }
}
