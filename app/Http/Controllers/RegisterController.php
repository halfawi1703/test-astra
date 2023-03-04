<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            return response()->json(['message' => 'User already registered'], 404);
        }

        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());
        return New UserResource($user);
    }
}
