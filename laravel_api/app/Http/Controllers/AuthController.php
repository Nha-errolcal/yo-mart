<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $token = auth('api')->login($user);

        return response()->json([
            'user' => $user,
            'message' => 'Account created successfully.',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user()->load('roles.permissions');

        $roles = $user->roles->map(fn($role) => [
            'id' => $role->id,
            'name' => $role->name,
            'code' => $role->code,
        ])->values();

        $permissions = $user->roles
            ->flatMap(fn($role) => $role->permissions)
            ->unique('id')
            ->values()
            ->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'code' => $p->code,
            ]);

        $dataUserOnly = $user->only(['id', 'name', 'email', 'create_by', 'created_at', 'updated_at']);

        return response()->json([
            'user' => $dataUserOnly,
            'message' => 'Login successful.',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'role' => $roles,
            'permission' => $permissions,
        ]);
    }

    public function profile()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return response()->json([
            'access_token' => JWTAuth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    /**
     * Assign roles to a user role_ids
     * POST /api/v2/users/{userId}/sync-roles
     */
    public function syncRoles(Request $request, $userId)
    {
        $data = $request->validate([
            'role_ids' => 'required|array',
            'role_ids.*' => 'integer|exists:role,id', // IMPORTANT: your table is role
        ]);

        $user = User::findOrFail($userId);
        $user->roles()->sync($data['role_ids']); // replace roles

        return response()->json([
            'message' => 'Roles synced successfully',
            'data' => $user->load('roles')
        ], 200);
    }
}
