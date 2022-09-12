<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Borrower;
use App\Http\Resources\LoanResource;
use App\Http\Requests\BorrowerRequest;
use App\Http\Services\BorrowerServices;
use App\Http\Resources\BorrowerResource;
use PDF;

class BorrowerController extends Controller
{    
    
    
    private $services;

    public function __construct(BorrowerServices $services)
    {

        $this->services =  $services;

    }

    public function index()
    {

        return $this->services->getAll();

    }

    public function show(Borrower $borrower)
    {

        return BorrowerResource::make($borrower->load('loans', 'loans.dueDates'));

    }

    public function edit(Borrower $borrower)
    {

        return $borrower;

    }

    public function store(BorrowerRequest $request)
    {      

        return $this->services->store($request);

    }

    public function update(BorrowerRequest  $request, Borrower $borrower)
    {  

        return $this->services->update($request, $borrower);

    }

    public function destroy(Borrower $borrower)
    {        

        return $this->services->destroy($borrower);

    }

    public function search($keyword)
    {

        return $this->services->search($keyword);

    }

    public function count()
    {       

        return $this->services->count();
        
    }



   

}
