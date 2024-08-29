<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //

    public function index()
    {
        $data = User::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function update(Request $request, User $user)
    {
        $formFields = $request->validate([
            'name' => 'string|max:225',
            'email' => 'string|email|unique:users,email,' . $user->id,
            'phone' => 'string',
            'password' => 'string|min:4'
        ]);

        if($request->has('password')) {
            $formFields['password'] = bcrypt($formFields['password']);
        }

        $user->update($formFields);

        return response()->json($user);
    }

    public function delete_user(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'deleted successfully',
            204
        ]);
    }
}
