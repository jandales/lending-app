<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPasswordRequest;

class ChangePasswordController extends Controller
{
    public function update(ResetPasswordRequest $request)
    {
        $user = $request->user();
        $user->password = Hash::make($request->password);
        return response()->json("Successfully password updated");
    }
}
