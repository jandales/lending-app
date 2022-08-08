<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentReportController extends Controller
{
    public function index(Request $request)
    {      

        $startdate = Carbon::parse($request->start_date);

        $endDate = Carbon::parse($request->end_date);

        $payments =  Payment::with('loan')
        ->whereBetween('created_at', [$startdate,$endDate])
        ->latest('created_at')
        ->get()
        ->map(function($payment) {
            return [
                "id" => $payment->id,           
                "due_date" => $payment->due_date,
                "amount" => $payment->amount,
                "status" => $payment->status,
                "remark" => $payment->remark,
                "created_at" => $payment->created_at->format('m-d-y'), 
                "loan" => [
                    "id" => $payment->loan->id,
                    "loan_number" => $payment->loan->loan_number,               
                    "balance_amount" =>  $payment->balance_amount,
                    "status" =>  $payment->status,
                ],
            ];
        });
        
        return $payments;

    }
}
