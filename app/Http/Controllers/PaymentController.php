<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Services\PaymentServices;
use App\Http\Resources\PaymentResource;
use App\Http\Requests\PaymentStoreRequest;

class PaymentController extends Controller
{
    private $services;

    public function __construct(PaymentServices $services)
    {

        $this->services = $services;

    }

    public function index(Request $request)
    {        
        $filter = $request->query('filter');
        $sort = $request->query('sort');
        $order = $request->query('order');
        return $this->services->getPaymentAll($filter, $sort, $order);       

    }

    public function store(PaymentStoreRequest $request)
    {       
        return $this->services->store($request->validated(), $request->user()->id);
    }

    // public function view(Payment $payment)
    // {

        
    //     return $this->services->view($payment);

    // }

    public function destroy(Payment $payment)
    {  
     
        return $this->services->destroy($payment); 
        
    }

    public function search(Request $request) 
    {      
        $keyword = $request->query('keyword');        
        return $this->services->search($keyword);
    }
   
}
