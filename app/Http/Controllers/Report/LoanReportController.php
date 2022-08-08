<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Http\Resources\LoanResource;

class LoanReportController extends Controller
{
  
    public function index(Request $request)
    {      

        $startdate = Carbon::parse($request->start_date);

        $endDate = Carbon::parse($request->end_date);

        $loans =  Loan::with('borrower')->whereBetween('created_at', [$startdate,$endDate])->latest('created_at')->get();
        
        return  LoanResource::collection($loans);

    }
}
