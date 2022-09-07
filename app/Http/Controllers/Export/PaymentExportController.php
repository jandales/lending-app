<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use App\Http\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Http\Reports\PaymentReports;

class PaymentExportController extends Controller
{
    private $report;

    public function __construct(PaymentReports $report)
    {
        $this->report = $report;
    }

    public function index(Request $request)
    {  

        $export  = new PaymentExport($request, $this->report);
        
        return $export->handleExport();

    }
}
