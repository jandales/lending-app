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
    
    private $services;
    
    public function __construct(UserServices $services)
    {

        $this->services = $services;
        
    }


    public function index()
    {
       
        return $this->services->getUsers();

    }

    public function edit(User $user) 
    {

        return UserEditResource::make($user);

    }

    public function updateUser(User $user,UserEditRequest  $request)
    {

        return $this->services->updateUser($user, $request);

    }

    public function store(UserStoreRequest  $request)
    { 

        return $this->services->store($request);

    }   

    public function user(Request $request)
    {

        return $request->user();

    }

    public function update(UserUpdateRequest $request)
    {
       
        return $this->services->update($request);

    }

    public function upload(Request $request)
    {       

        return  $this->services->uploadAvatar($request);

    }

    public function destroy(User $user)
    {

        return $user->delete();

    }

    
}
