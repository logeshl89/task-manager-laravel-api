<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\ConflictException;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreUserRequest;
use App\Http\Requests\v1\UpdateUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     tags={"Users"},
     *     summary="Create user",
     *     operationId="createUser",
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", example="teste",),
     *             @OA\Property(property="email", example="teste@gmail.com"),
     *             @OA\Property(property="password",example="teste123"),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="400",description="Bad Request"),
     *     @OA\Response(response="409",description="Conflict"),
     * )
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();
        $hashedPass = Hash::make($request->password);

        $userEmail = User::where(['email' => $data['email']])->first();
        if ($userEmail) throw new ConflictException();

        $user = User::create([...$data, 'password' => $hashedPass]);
        return new UserResource($user);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     tags={"Users"},
     *     summary="Get user data",
     *     operationId="getUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden"),
     *     @OA\Response(response="404", description="Not Found"),
     * )
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/users/{id}",
     *     tags={"Users"},
     *     summary="Update user",
     *     operationId="updateUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", example="teste atualizado",),
     *             @OA\Property(property="email", example="teste_atualizado@gmail.com"),
     *             @OA\Property(property="password", example="teste123"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden"),
     *     @OA\Response(response="404", description="Not Found"),
     * )
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->all();
        $user = User::findOrFail($id);
        $hashedPass = Hash::make($request->password);
        $this->authorize('update', $user);
        $user->update([...$data, 'password' => $hashedPass]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     tags={"Users"},
     *     summary="Delete user",
     *     operationId="deleteUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden"),
     *     @OA\Response(response="404", description="Not Found"),
     * )
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
    }
}
