<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentDueDate;


class PaymentDueDateController extends Controller
{

    public function index($id)
    {

        return PaymentDueDate::where('loan_id', $id)->get();

    }

    public function show($id)
    {

        return PaymentDueDate::findorfail($id);

    }
}
