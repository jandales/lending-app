<?php

namespace App\Http\Controllers;

use App\Models\LoanType;
use Illuminate\Http\Request;
use App\Http\Requests\LoanTypeStorRequest;
use App\Http\Requests\LoanTypeUpdateRequest;

class LoanTypeController extends Controller
{
    public function index()
    {
        return LoanType::all();
    }

    public function show($id)
    {
        return LoanType::findorfail($id);
    }

    public function store(LoanTypeStorRequest $request){
        $validated = $request->validated();        
        $validated['user_id'] = $request->user()->id;
        $validated['description'] = $request->description;
        return LoanType::create($validated);
    }

    public function update(LoanTypeUpdateRequest $request, $id)
    {        
       
        $type = LoanType::findorfail($id);
        $type->type = $request->type;
        $type->description = $request->description;
        $type->interest = $request->interest;
        $type->save();        
        return $type;
    }

    public function destroy($id)
    {
        $type = LoanType::findorfail($id);
        $type->delete();
        return response()->noContent();
    }
}
