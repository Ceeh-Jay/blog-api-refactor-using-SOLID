<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function register(Request $request)
    {
        $user = $this->authService->register($request->all());
        return response()->json($user, 201);
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        $tokenResponse = $this->authService->login($credentials);
        return response()->json($tokenResponse);
    }
    public function me()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized action'], 401);
        }
        return response()->json($user);
    }
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        $tokenResponse = $this->authService->getTokenRespose(JWTAuth::refresh());
        return response()->json($tokenResponse);
    }
}
