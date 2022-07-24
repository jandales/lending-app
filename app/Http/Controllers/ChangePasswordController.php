<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;

class ChangePasswordController extends Controller
{
    public function update(ResetPasswordRequest $request)
    {
        
        $user = $request->user(); 
        $current_password = $request->current_password;  

        if (!Hash::check($current_password, $user->password)) {           
            return response()->json(["status" => 500 , 'message' => "Wrong password"]);
        } 
        
        $user->password = Hash::make($request->password);
        $user->save();
      
        return response()->json("Successfully password updated");
    }
}
