<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\LoanServices;

class LoanController extends Controller
{
    private $services;

    public function __construct(LoanServices $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        return $this->services->getLoans();
    }

    public function store(LoanStoreRequest $request)
    {
        return $this->services->store($request);
    }

    

}
