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
  
        if (auth()->user()->cannot('viewAny', Interest::class)) {

            abort(403);

        }

        return Interest::all();

    }

    public function store(InterestStoreRequest $request)
    {   
        if ($request->user()->cannot('create', Interest::class)) {

            abort(403);

        }

        return Interest::create($request->validated());
    }
    
    public function show(Interest $interest)
    {
        if (auth()->user()->cannot('view', $interest)) {
            
            abort(403);

        }

        return $interest;
    }

    public function update(InterestUpdateRequest $request, Interest $interest)
    {   
            
        if ($request->user()->cannot('update', $interest)) {

            abort(403);

        }

        $interest->value = $request->value;

        $interest->save();

        return $interest;

    }


    public function destroy(Interest $interest)
    {
        if (auth()->user()->cannot('delete', $interest)) {
            abort(403);
        }

        $interest->delete();
        return;
    }
}
