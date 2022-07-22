<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Jobs\ProcessForgotPassword;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        $email =  $validated['email'];

        $user = User::where('email', $email)->first();
        
        if($user == null) return;

        $token = Str::random(64);    

        PasswordReset::Create([
            'email' => $request->email,
            'token' => $token, 
            'created_at' => now(),         
        ]);

        $url = url("/reset_password/{$token}");         
        
        dispatch(new ProcessForgotPassword($url, $email));

        return response()->json(['success' => 'Please check your Email to reset your password']);

    }
}


