<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Password;
use Illuminate\Http\Request;
use App\Jobs\ProccessSendPassword;



class PasswordController extends Controller
{
    public function reset($user_id)
    {
        $user = User::find($user_id);     

        if (!$user) return  response()->json(['message' => 'User not found']);

        $password = Password::generate();   
        $user->password = Password::make($password);
        $user->save();  

        dispatch(new ProccessSendPassword($user->email, $password));

        return response()->json(['message' => 'Successfully reset password']);
    }

 
}
