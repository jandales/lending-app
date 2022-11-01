<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Services\AccountServices;
use App\Http\Requests\UserUpdateRequest;

class AccountController extends Controller
{
    private $services;

    public function __construct(AccountServices $services)
    {
        
        $this->services = $services;

    }


    public function user(Request $request)
    {

        return UserResource::make($request->user());

    }

    public function update(UserUpdateRequest $request)
    {
     
        return $this->services->update($request);

    }

    public function upload(Request $request)
    {       

        return  $this->services->uploadAvatar($request);

    }

   
}
