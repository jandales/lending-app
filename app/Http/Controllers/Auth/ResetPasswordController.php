<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function index($token)
    {
        $resetpassword = PasswordReset::where('token', $token)->first();

        if ($resetpassword == null) {
            abort(404);
        }

        $difference = Self::timeDiffer($resetpassword->created_at); 

        if($difference > 24){
            abort(404);
        }

        $data = ['email' => $resetpassword->email, 'token' => $resetpassword->token];

        return response()->json($data);
    }

    public function reset(ResetPasswordRequest $request)
    {       
        $resetpassword = PasswordReset::where('email', $request->email)->first();
        $user = $resetpassword->user;
        $user->password = Hash::make($request->password);
        $user->save();  
        
        return  response()->json([ 'status' => 200, 'message' => 'Password Successfully reset']);
    }

    private function timeDiffer($date)
    {
        $dt = Carbon::now();
        return $dt->diffInHours(Carbon::parse($date));  
        
    }
}
