<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Reports\PaymentReports;
use App\Http\Requests\ReportDateRequest;

class PaymentReportController extends Controller
{
    private $report;

    public function __construct(PaymentReports $report)
    {

        $this->report = $report;

    }


    public function index(ReportDateRequest $request)
    {     

        return $this->report->generate($request->start_date, $request->end_date); 

    }

   

}
