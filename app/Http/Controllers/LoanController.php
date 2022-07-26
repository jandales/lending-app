<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Services\LoanServices;
use App\Http\Requests\LoanStoreRequest;

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

    public function view(Loan $loan)
    {       
       
        return $this->services->getLoan($loan);
    }

    public function destroy(Loan $loan)
    {
        return $loan->delete();
    }

    

}
