<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BorrowerResource;

class BorrowerReportController extends Controller
{
    public function index(Request $request)
    {
        
        $startDate = Carbon::parse($request->start_date);

        $endDate = Carbon::parse($request->end_date);
        
        return Borrower::whereHas('loans')
                        ->withSum(['loans' => function($query) use($startDate, $endDate) {
                            $query->whereBetween('created_at', [$startDate, $endDate]);           
                        }], 'total_amount')        
                        ->get()
                        ->map(function($borrower)  {
                            return $this->format($borrower); 
                        });

        // return Borrower::withSum('loans', 'total_amount')
        // ->get()
        // ->map(function($borrower)  {
        //     return  [              
        //         'id' => $borrower->id,
        //         'name' => $borrower->firstname . " " . $borrower->lastname,
        //         'email' =>$borrower->email,
        //         'phone' => $borrower->phone,
        //         'address' => $borrower->address,
        //         'avatar' => $borrower->avatar,
        //         'status' => $borrower->status,
        //         'loans_sum_total_amount' => $borrower->loans_sum_total_amount,
        //     ];
           
          
        // });
      
    }

    public function format($borrower){
        return  [              
            'id' => $borrower->id,
            'name' => $borrower->firstname . " " . $borrower->lastname,
            'email' =>$borrower->email,
            'phone' => $borrower->phone,
            'address' => $borrower->address,
            'avatar' => $borrower->avatar,
            'status' => $borrower->status,
            'created_at' => $borrower->created_at->format('m-d-y'),
            'loans_sum_total_amount' => $borrower->loans_sum_total_amount ?? 0,
        ]; 
    }
}
