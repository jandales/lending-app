<?php 

namespace App\Http\Reports;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Borrower;
use App\Http\Reports\Report;
use Illuminate\Http\Request;

class PaymentReports implements Report {

    
    public function generate($start, $end, $filter = null) 
    {
        $start = Carbon::parse($start);

        $end = Carbon::parse($end);

        return Payment::with('loan', 'borrower')

                    ->whereBetween('created_at', [$start,$end])

                    ->latest('created_at')

                    ->get()

                    ->map(function($payment) {

                        return $this->format($payment);

                     });

    }

    private function format($payment){

        return [

            "id" => $payment->id, 

            "due_date" => Carbon::parse($payment->due_date)->format('M-d-Y'),

            "amount" => $payment->amount,

            "status" => $payment->status,

            "remark" => $payment->remark,

            "paid_at" => $payment->created_at->format('M-d-Y'), 

            'borrower' => $payment->borrower->firstname . " " . $payment->borrower->lastname,

            "loan" => [

                "id" => $payment->loan->id,

                "loan_number" => $payment->loan->loan_number,  

                "balance_amount" =>  $payment->balance_amount,

                "status" =>  $payment->status,

            ],

        ];

    }

}