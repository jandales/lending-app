<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Illuminate\Http\Request;
use App\Http\Services\FundServices;
use App\Http\Requests\ActivityStoreRequest;

class FundController extends Controller
{
    private FundServices $services;

    public function __construct(FundServices $services) {
        $this->services = $services;
    }

    public function index()
    {
        return $this->services->getFund();
    }

    public function store(Request $request)
    {
        $this->services->storeInitialFund($request);
    }

    public function has()
    {
        return $this->services->hasFunds();
    }

    public function add(ActivityStoreRequest $request)
    {            
        $amount = $request->amount;
        $remark = $request->remark;
        $user = $request->user()->id;
        return $this->services->addFund($amount, $user, $remark);
    }

    public function deduct(ActivityStoreRequest $request)
    {    
        $amount = $request->amount;
        $remark = $request->remark;
        $user = $request->user()->id;    
        return $this->services->deductFund($amount, $user, $remark );
    }

}
