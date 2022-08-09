<?php 

namespace App\Http\Reports;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Borrower;
use App\Http\Reports\Report;
use Illuminate\Http\Request;

class LoanReports implements Report {

    public function generate($start, $end, $filter = null)
    {
        $start = Carbon::parse($start);
        
        $end = Carbon::parse($end);  

        return Loan::with('borrower')->whereBetween('created_at', [$start,$end])->latest('created_at')->get();
    }  

}