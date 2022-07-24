<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\UserServices;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    
    private $services;
    
    public function __construct(UserServices $services)
    {
        $this->services = $services;
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

    
}
