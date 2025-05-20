<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming you have a User model

class UserController extends Controller
{
    //

    public function register(Request $request)
    {
        // Validate the request data
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // Create a new user instance
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        // Return a response
        $response = [
            'message' => 'User registered successfully',
            'user' => $user,
        ];

        return response()->json($response, 201);
    }
}
