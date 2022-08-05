<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Http\Requests\BorrowerRequest;
use App\Http\Services\BorrowerServices;

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

    public function view($id)
    {

        return $this->services->getCustomerById($id); 

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
