<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function attempt(LoginRequest $request)
    {
        $validated = $request->validated(); 
        $user = User::where('email', $validated['email'])->first();
        if(!$user || !Hash::check($validated['password'],$user->password))
        {        
            return response()->json([
                'errors' => [
                    'message' => "Your credetials is invalid",
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken($user->id);
                 
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);          
    }
}
