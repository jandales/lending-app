<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use App\Http\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Http\Reports\PaymentReports;
use PDF;

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

    public function createPDF(Request $request)
    {
        $payments =  $this->report->generate($request->start_date, $request->end_date);

        view()->share(['payments' => $payments, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);

        $pdf = PDF::loadView('payment', $payments->toArray());

        return $pdf->output();
    }
}
