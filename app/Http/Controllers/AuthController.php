<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function register_user(RegisterUserRequest $request)
    {
        try{

            $formFields = $request->validated();
    
            $formFields['password'] = bcrypt($formFields['password']);
    
            $user = User::create($formFields);
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'error' => $e->errors()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'error during registration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function user_login(UserLoginRequest $request)
    {
        try {
            $formFields = $request->validated();
    
            if(!Auth::attempt($formFields)) {
                throw ValidationException::withMessages([
                    'email' => 'Incorrect Email or Credential'
                ], 401);
            }
    
            $user = User::where('email', $formFields['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invaild Credentials',
                'error' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'error occur during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged Out Successfully'
        ]);

    }
}
