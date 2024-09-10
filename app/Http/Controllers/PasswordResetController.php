<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function forgetPassword(Request $request)
    {
        $reset_email = $request->validate([
            'email' => 'required|email'
        ]); 

        $user = User::where('email', $reset_email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The email provided is not registered']
            ]);
        }

        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->save();

        return response()->json([
            'message' => 'password has been resetted',
            'token' => $token,
        ]);
    }

    
    public function resetPassword(Request $request)
    {
        $reset_password = $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:4'
        ]);

        $user = User::where('email', $reset_password['email'])
                        ->where('password_reset_token', $reset_password['token'])
                        ->first();

        if(!$user) {
            throw ValidationException::withMessages([
                'email' => ['The credentials provided is invalid']
            ]);
        }

        $user->password = Hash::make($reset_password['password']);
        $user->password_reset_token = null;
        $user->save();

        return response()->json([
            'message' => 'Password has been successfully reset'
        ]);
    }
}
