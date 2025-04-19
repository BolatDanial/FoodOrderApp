<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    protected $service;
    public function __construct(AuthService $authService)
    {
        $this->service = $authService;
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|min:6|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $this->service->register($request->only('name', 'email', 'password'));
        $user->save();

        return response()->json(["user" => $user], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->get('email'))->first();

        if (!$user ||  !Hash::check($request->get('password'), $user->password)) {
            return response()->json(['errors' => ['The provided credentials are incorrect.']], 422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['username' => $user->name, 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(["message" => "Logged out"], 200);
    }

    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json($user, 200);
    }
}
