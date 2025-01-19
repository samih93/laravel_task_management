<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getProfile($id)
    {
        $user =   User::find($id)->profile;
        return response()->json($user, 200);
    }

    public function getUserTasks($id)
    {
        $user =   User::find($id)->tasks;
        return response()->json($user, 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user =   User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return  response()->json(
            [
                'message' => 'user registered succeffully',
                'user' => $user,
            ],
            201
        );
    }
    public function login(Request $request)
    {
        $request->validate([

            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(["invalid email or password",], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken("auth_token")->plainTextToken;

        return  response()->json(
            [
                'message' => 'login successfully',
                'user' => $user,
                'token' => $token
            ],
            201
        );
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
