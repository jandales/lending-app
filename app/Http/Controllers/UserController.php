<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\UserServices;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserEditResource;

class UserController extends Controller
{
    
    private UserServices $services;
    
    public function __construct(UserServices $services)
    {
        $this->services = $services;        
    }

    public function index()
    {
        if (auth()->user()->cannot('viewAny', User::class)) {
            abort(403);
        }

        return $this->services->getUsers();

    }

    public function edit(User $user) 
    {

        if (auth()->user()->cannot('view', $user)) {
            abort(403);
        }

        return UserEditResource::make($user);

    }

    public function update(User $user, UserEditRequest $request)
    {

        if ($request->user()->cannot('update', $user)) {
            abort(403);
        }

        return $this->services->update($user, $request);

    }

    public function store(UserStoreRequest  $request)
    { 
        if ($request->user()->cannot('create',  User::class)) {
            abort(403);
        }

        return $this->services->store($request);

    }  
    
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->cannot('delete', $user)) {
            abort(403);
        }
        
        return $user->delete();

    }

    
}
