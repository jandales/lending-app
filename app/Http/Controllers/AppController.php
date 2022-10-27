<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Capital;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LoanResource;


class AppController extends Controller
{
    public function dashboard()
    {

        $borrowers_count = Borrower::count();    
        $active_loan =  Loan::Active()->count();
        $loans = LoanResource::collection(Loan::with('borrower')->latest('created_at')->limit(10)->get());
        $capital =  Capital::GetCapital()->first();
        $total_interest = Loan::TotalInterest();

        return response()->json([
            'loans' => $loans,
            'borrower_count' => $borrowers_count,            
            'revenue' => 0,
            'current_capital' => $capital->current_capital,
            'active_loan' => $active_loan,
            'total_interest' => $total_interest,
        ]);
        
    }

    public function setCookie(Request $request) {
        $minutes = 5;
        $response = new Response('Hello World');
        $response->withCookie(cookie('name', 'virat', $minutes));
        return $response;
    }

    public function getCookie(Request $request) {
        $value = $request->cookie('name');
        return $value;
    }
    
}
