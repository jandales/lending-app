<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LoanResource;


class AppController extends Controller
{
    public function dashboard()
    {

        $customersCount = Borrower::count();

        $capital =  Loan::Capital();

        $revenue = Loan::Revenue();

        $activeLoan =  Loan::Active()->count();

        $loans = LoanResource::collection(Loan::with('borrower')->latest('created_at')->limit(10)->get());

        return response()->json([

            'loans' => $loans,

            'customersCount' => $customersCount,

            'capital' => $capital,

            'revenue' => $revenue,

            'activeLoan' => $activeLoan,

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
