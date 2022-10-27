<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\FundServices;

class FundController extends Controller
{
    public function hasFunds(FundServices $services)
    {
        return $services->hasFunds();
    }

}
