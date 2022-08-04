<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Services\LoanServices;
use App\Http\Requests\StatusRequest;
use App\Http\Resources\LoanResource;
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

    public function view($id)
    { 

        return $this->services->getLoan($id);

    }

    public function getLoanByCustomer($id)
    {

        return $this->services->getLoanByCustomer($id);

    }

    public function destroy(Loan $loan)
    {

        $loan->status = 'void';

        $loan->save();

        return;

    }

    public function search($keyword)
    {        

       return LoanResource::collection(Loan::Search($keyword));

    }

    public function updateStatus(StatusRequest $request, Loan $loan)
    {    

       return  $this->services->updateStatus($loan, $request->status);

    }

    public function exist($id)
    {   

        $exist = $this->services->existLoan($id);

        return response()->json(['status' => $exist]); 

    }

    

}
