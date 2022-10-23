<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Loan;
use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Http\Resources\LoanResource;
use App\Http\Requests\BorrowerRequest;
use App\Http\Services\BorrowerServices;
use App\Http\Resources\BorrowerResource;

class BorrowerController extends Controller
{    
    
    
    private $services;

    public function __construct(BorrowerServices $services)
    {

        $this->services =  $services;

    }

    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $sortName = $request->query('sort');
        $order = $request->query('order');
        return $this->services->getAll($filter, $sortName, $order);

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

    public function search(Request $request)
    {
        $keyword = $request->query('keyword');
        return $this->services->search($keyword);

    }

    public function count()
    {       

        return $this->services->count();
        
    }



   

}
