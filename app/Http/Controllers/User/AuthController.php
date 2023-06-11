<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //

    // Register User
    public function register(Request $request)
    {
        // validate fields
        $attrs = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // create user
        $user = User::create([
            'name' => $attrs['name'],
            'email' => $attrs['email'],
            'password' => bcrypt($attrs['password'])
        ]);

        // return user & token in response
        return response([
            'user' => $user,
            'token' => $user->createToken('secret')->plainTextToken
        ], 200);

    }

    // Login User
    public function login(Request $request)
    {
        // validate fields
        $attrs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // attempt login
        if (!Auth()->attempt($attrs)) {
            return response([
                'message' => 'Invalid credentials.'
            ], 403);
        }

        // return user & token in response
        return response([
            'user' => auth()->user(),
            'token' => auth()->user()->createToken('secret')->plainTextToken
        ], 200);

    }

    // Logout User
    public function logout()
    {
        // revoke token
        auth()->user()->tokens()->delete();

        // return response
        return response([
            'message' => 'Logged out successfully.'
        ], 200);

    }

    // Get User details
    public function user(Request $request)
    {
        // return user details
        return response([
            'user' => auth()->user()
        ], 200);

    }

        // Update User details
        public function update(Request $request)
        {
            $attrs = $request->validate([
                'name' => 'required|string'
            ]);

            auth()->user()->update([
                'name' => $attrs['name'],
            ]);

            return response([
                'message' => 'User updated.',
                'user' => auth()->user()
            ], 200);
        }


}