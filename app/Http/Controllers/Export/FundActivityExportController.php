<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Http\Exports\FundActivityExport;

class FundActivityExportController extends Controller
{
    public function index()
    {
        $export = new FundActivityExport();

        return $export->handleExport();
    }
}
