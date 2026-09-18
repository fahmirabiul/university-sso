<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Services\UserService;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct(
        private readonly UserService $userService,
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return $this->successResponse('User registered successfully.', $user, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->authenticate($request->validated());

        if (!$result) {
            return $this->errorResponse('Invalid credentials or inactive account.', 401);
        }

        return $this->successResponse('Login successful.', $result);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('profile', 'roles');

        return $this->successResponse('User retrieved successfully.', $user);
    }
}
