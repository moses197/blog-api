<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function register_user(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|string|max:225',
            'email' => 'required|email|unique:users',
            'phone' => 'string',
            'password' => 'required|min:4'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function user_login(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!Auth::attempt($formFields)) {
            throw ValidationException::withMessages([
                'email' => ['Incorrect Email or Credential']
            ]);
        }

        $user = User::where('email', $formFields['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out Successfully'
        ]);

    }
}
