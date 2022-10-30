<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Illuminate\Http\Request;
use App\Http\Services\FundServices;

class FundController extends Controller
{
    private FundServices $services;

    public function __construct(FundServices $services) {
        $this->services = $services;
    }

    public function store(Request $request)
    {
        $this->services->storeInitialFund($request);
    }

    public function hasFunds()
    {
        return $this->services->hasFunds();
    }

    public function addFund(Request $request)
    {        
        $this->services->addFund($request);
    }

    public function deductFund(Request $request)
    {
        $this->services->deductFund($request);
    }

}
