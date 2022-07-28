<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Customer;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function dashboard()
    {
        $customersCount = Customer::count();
        $capital =  Loan::Capital();
        $revenue = Loan::Revenue();

        return response()->json(['customersCount' => $customersCount, 'capital' => $capital, 'revenue' => $revenue]);
    }

    
}
