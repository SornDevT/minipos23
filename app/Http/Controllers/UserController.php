<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
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

    public function login(Request $request)
    {
        $user_login = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // check remember me
        if ($request->remember) {
            // set time 
            JWTAuth::factory()->setTTL(60*24*7); // 7 days
            // JWTAuth::factory()->setTTL(1); // 7 days
        }



        $token = JWTAuth::attempt($user_login);
        $user = Auth::user();

       if($token){
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'ອີເມວ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກ',
            ]);
        }
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        if ($token) {
            JWTAuth::invalidate($token);
            return response()->json([
                'success' => true
                ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Token not found'
            ], 401);
        }
    }
}
