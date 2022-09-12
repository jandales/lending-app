<?php 

namespace App\Http\Reports;

use App\Models\Borrower;
use App\Http\Reports\Report;
use Illuminate\Http\Request;

class BorrowersReport implements Report {

    
    public function generate($start, $end, $filter = null) 
    {
        return Borrower::whereHas('loans')

            ->withCount('loans')

            ->withSum(['loans' => function($query) use($start, $end) {

                $query->whereBetween('created_at', [$start, $end]); 

            }], 'total_amount')   

            ->get()

            ->map(function($borrower)  {

                return $this->format($borrower); 
                
            });

    }

    public function generateAll()
    {
        return Borrower::whereHas('loans')

            ->withCount('loans')

            ->withSum('loans', 'total_amount')   

            ->get()

            ->map(function($borrower)  {
                return $this->format($borrower);             
            });
    }

    private  function format($borrower)
    {
        return  [   

            'id' => $borrower->id,

            'name' => $borrower->firstname . " " . $borrower->lastname,

            'email' =>$borrower->email,

            'phone' => $borrower->phone,

            'address' => $borrower->address,

            'avatar' => $borrower->avatar,

            'status' => $borrower->status,

            'loans_sum_total_amount' => $borrower->loans_sum_total_amount ?? 0,

            'loans_count' => $borrower->loans_count,

            'created_at' => $borrower->created_at->format('M-d-Y'),

        ]; 
    }

}