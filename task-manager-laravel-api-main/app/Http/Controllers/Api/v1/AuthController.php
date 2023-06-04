<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Auth"},
     *     summary="Authenticate user",
     *     operationId="login",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", example="teste@gmail.com"),
     *             @OA\Property(property="password", example="teste123"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="Bad Request"),
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->all();
        if (!Auth::attempt($credentials)) throw new InvalidCredentialsException();

        $user = User::where(['email' => $credentials['email']])->first();

        return [
            'accessToken' => $user->createToken('Api token of ' . $user->name)->plainTextToken
        ];
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Auth"},
     *     summary="Revoke API Token from user",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'revoked' => true
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/v1/profile",
     *     tags={"Auth"},
     *     summary="Get user profile",
     *     operationId="profile",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     * )
     */
    public function profile(Request $request)
    {
        return $request->user();
    }
}
