<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use App\Http\Services\CustomerServices;


class CustomerController extends Controller
{    
    private $services;

    public function __construct(CustomerServices $services)
    {
        $this->services =  $services;
    }

    public function index()
    {
        return $this->services->getAll();
    }

    public function view(Customer $customer)
    {
        return $customer;
    }

    public function store(CustomerRequest $request)
    {      
        return $this->services->store($request);
    }

    public function update(CustomerRequest  $request, Customer $customer)
    {  
        return $this->services->update($request, $customer);
    }

    public function destroy(Customer $customer)
    {        
        return $this->services->destroy($customer);
    }

    public function search($keyword)
    {
        return $this->services->search($keyword);
    }

}
