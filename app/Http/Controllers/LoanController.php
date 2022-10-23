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

    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $sort = $request->query('sort');
        $order = $request->query('order');
        return $this->services->getLoans($filter, $sort, $order);

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
        if (auth()->user()->cannot('delete', $loan)) {

            abort(403);

        }

        $loan->status = 'void';

        $loan->save();

        return;

    }

    public function search(Request $request)
    {        
       $keyword = $request->query('keyword');     
       return $this->services->search($keyword);
    }

    public function updateStatus(StatusRequest $request, Loan $loan)
    {    

        if ($request->user()->cannot('update', $loan)) {

            abort(403);

        }

       return  $this->services->updateStatus($loan, $request->status);

    }

    public function exist($id)
    {   

        $exist = $this->services->existLoan($id);

        return response()->json(['status' => $exist]); 

    }

    public function activeLoan($id) 
    {
        $loan = Loan::with('dueDates')->where(['borrower_id' => $id, 'status' => 'active'])->first();
        
        return  LoanResource::make($loan);

    }

    



    

}
