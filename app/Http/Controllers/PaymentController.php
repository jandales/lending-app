<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentStoreRequest;

class PaymentController extends Controller
{
    public function index()
    {
        return Payment::with('customer', 'loan')->where('status', 'paid')->get();
    }

    public function store(PaymentStoreRequest $request)
    {
        $validated =$request->validated();
        $validated['remark'] = $request->remark;
        $validated['user_id'] = $request->user()->id;
        $validated['status'] = 'paid';
        return Payment::create($validated);
    }

    public function view(Payment $payment)
    {
        return $payment;
    }

    public function destroy(Payment $payment)
    {
        $payment->status = 'void';
        $payment->save();
    }
    
}
