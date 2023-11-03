<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends ApiController
{

    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     summary="user register",
     *     @OA\Parameter (
     *          in="query",
     *          name="name",
     *          @OA\Schema (type="string")
     *     ),
     *     @OA\Parameter (
     *          in="query",
     *          name="email",
     *          @OA\Schema (type="email")
     *     ),
     *     @OA\Parameter (
     *          in="query",
     *          name="password",
     *          @OA\Schema (type="password")
     *     ),
     *     @OA\Parameter (
     *          in="query",
     *          name="password_confirmation",
     *          @OA\Schema (type="password")
     *     ),
     *     @OA\Response (
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     * )
     */
    public function register(RegisterRequest $request) {

        unset($request['password_confirmation']);

        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->all());

        $token = $user->createToken('app')->plainTextToken;

        return response(['user' => $user, 'token' => $token]);

    }

    /**
     * @OA\Post(
     *     path="/login",
     *     tags={"Auth"},
     *     summary="User Login",
     *     @OA\Parameter (
     *          in="query",
     *          name="email",
     *          @OA\Schema (type="email")
     *     ),
     *     @OA\Parameter (
     *          in="query",
     *          name="password",
     *          @OA\Schema (type="password")
     *     ),
     *     @OA\Response (
     *          response=200,
     *          description="Successful operation"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *     ),
     *     @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *     ),
     * )
     */
    public function login(LoginRequest $request) {

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response([
                'message' => 'Bad request'
            ], 401);
        }

        $token = $user->createToken('app')->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);

    }

    /**
     * @OA\Get(
     *      path="/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Get blog with full content",
     *      description="User logout",
     *      security={{"sanctum": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function logout() {

        auth()->user()->tokens()->delete();

        return response(['message' => 'Logged out']);
    }
}
