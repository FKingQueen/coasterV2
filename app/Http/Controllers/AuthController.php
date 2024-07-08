<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // return $request;
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token]);
        }
        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'error' => ['Email not found.'],
            ]);
        }

        // If Auth::attempt fails due to incorrect password, return an error message
        throw ValidationException::withMessages([
            'error' => ['Incorrect Password.'],
        ]);
    }

    public function register(Request $request){
        $validated = $request->validate([
            'email' => "required|email|unique:users,email,$request->id",
        ]);
        // Your registration logic here

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);


        return response()->json(['message' => 'User registered successfully']);
    }

    public function regEmail(){

        return $emails = User::pluck('email');
        return response()->json(['emails' => $emails]);
    }
}
