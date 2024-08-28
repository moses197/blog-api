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
        return User::all();
    }

    public function update(Request $request)
    {
        $formFields = $request->validate([
            'name' => '',
        ]);
    }
}
