<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Exports\BorrowerExport;
use App\Http\Reports\BorrowersReport;


class BorrowerExportController extends Controller
{
    private $report;

    public function __construct(BorrowersReport $report)
    {
        $this->report = $report;
    }

    public function index(Request $request)
    {  

        $export  = new BorrowerExport($request, $this->report);
        
        return $export->handleExport();

    }
}
