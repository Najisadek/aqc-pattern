<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\User\{LoginUserRequest, RegisterUserRequest, UpdateUserRequest};
use App\AQC\V1\User\{CreateUser, GetUsers, LoginUser, UpdateUser};
use Illuminate\Http\{JsonResponse, Request};
use App\Models\User;

final class UserController
{
    public function index(Request $request): JsonResponse
    {
        $users = (new GetUsers)->handle($request->all());

        return response()->json($users);
    }

    public function store(RegisterUserRequest $request): JsonResponse
    {
        $user = (new CreateUser)->handle($request->validated());

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = (new UpdateUser)->handle($user, $request->validated());

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(null, 204);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = (new LoginUser)->handle($request->validated());

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}