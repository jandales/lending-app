<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Reports\BorrowersReport;
use App\Http\Requests\ReportDateRequest;

class BorrowerReportController extends Controller
{
    
    private $reports;

    public function __construct(BorrowersReport $reports)
    {

        $this->reports = $reports;

    }


    public function index(ReportDateRequest $request)
    {

        $start = Carbon::parse($request->start_date);

        $end = Carbon::parse($request->end_date);

        return $this->reports->generate($start, $end); 
      
    }

   
}
