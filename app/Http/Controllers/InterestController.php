<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use App\Http\Requests\InterestStoreRequest;
use App\Http\Requests\InterestUpdateRequest;

class InterestController extends Controller
{
    public function index()
    {
        return Interest::all();
    }

    public function store(InterestStoreRequest $request)
    {   
        return Interest::create($request->validated());
    }
    
    public function view(Interest $interest)
    {
        return $interest;
    }

    public function update(InterestUpdateRequest $request, Interest $interest)
    {       
        $interest->value = $request->value;
        $interest->save();
        return $interest;
    }
    public function destroy(Interest $interest)
    {
        $interest->delete();
        return;
    }
}
