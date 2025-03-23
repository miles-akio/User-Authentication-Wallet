<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Handles user signup by validating input, hashing passwords, and saving users to the database.
    public function signup(Request $request)
    {
        // Validate incoming request fields (username and password are required).
        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Hash the password for secure storage in the database.
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create a new user record in the database.
        $user = User::create($validatedData);

        // Return a success response to the client.
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    // Handles user login, validates credentials, and returns a JWT token.
    public function login(Request $request)
    {
        // Validate incoming login credentials.
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user with the provided credentials.
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Return the generated JWT token to the client.
        return response()->json(['token' => $token], 200);
    }
}
