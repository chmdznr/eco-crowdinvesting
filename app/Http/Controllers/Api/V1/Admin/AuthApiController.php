<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function __construct()
    {
    }
     /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     tags={"Auth"},
     *     summary="",
     *     operationId="Login",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *              @OA\Property(property="email",type="string"),
     *              @OA\Property(property="password",type="string")
     *            )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|max:255',
            'password' => 'required|string|max:255'
        ]);
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        $user = User::where('email', $request->email)->with(['roles'])->firstOrFail();
        $token = $user->createToken('auth-sanctum')->plainTextToken;
        return response()->json([
            'data'  => $user,
            'token' => $token,
            'type'  => 'Bearer'
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     tags={"Auth"},
     *     summary="",
     *     operationId="Logout",
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *            mediaType="application/json"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     *
     * @param int $id
     */
    public function Logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'logout success']);
    }
}
