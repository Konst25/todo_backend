<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request) {
        // return User::create($request->all());
        $user = User::create($request->all());

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register user'
            ], 500); // Возвращаем статус 500 в случае ошибки
        }
    }

    public function login(LoginUserRequest $request) {

        if(!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'message' => 'Wrong email or password',
            ], 401);
        }

        // $user = Auth::user();
        $user = User::query()->where('email', $request->email)->first();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            // 'id' => $user->id,
            // 'name' => $user->name,
            // 'email' => $user->email,
            'token' => $user->createToken("Token of user: {$user->name}")->plainTextToken,
        ]);

    }

    public function logout() {

        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Необходимо авторизоваться.'
        ]);
    }
}
