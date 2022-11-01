<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Loan;
use App\Models\Capital;
use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Services\FundServices;
use App\Http\Resources\LoanResource;

class DashboardController extends Controller
{
    public function dashboard(FundServices $fundServices)
    {         
  
        $loans = LoanResource::collection(Loan::with('borrower')->latest('created_at')->limit(10)->get());    

        return response()->json([
            'loans' => $loans,
            'borrower_count' => Borrower::count(),  
            'current_capital' => Fund::Capital(),
            'active_loan' => Loan::Active()->count(),
            'collectable_interest' => Loan::CollectableInterest(),
            'total_interest' => Loan::TotalInterest(),
            'total_collected_interest' => Loan::TotalCollectedInterest(),
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
