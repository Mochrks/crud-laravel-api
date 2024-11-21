<?php

namespace App\Http\Controllers;

use App\Services\UserServices;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @OA\Post(
     *      path="/user-management/users/signin",
     *      operationId="signin",
     *      tags={"User Management"},
     *      summary="Sign in user",
     *      description="Sign in user and generate authentication token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"username", "password"},
     *              @OA\Property(property="username", type="string", example="john_doe"),
     *              @OA\Property(property="password", type="string", format="password", example="password123"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Login successful",
     *          @OA\JsonContent(
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="token", type="string", example="JWT_token"),
     *                  @OA\Property(property="type", type="string", example="Bearer"),
     *                  @OA\Property(property="username", type="string", example="john_doe"),
     *                  @OA\Property(property="role", type="string", example="users"),
     *              ),
     *              @OA\Property(property="message", type="string", example="Login successful"),
     *              @OA\Property(property="statusCode", type="integer", example=200),
     *              @OA\Property(property="status", type="string", example="success"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Invalid credentials"),
     *              @OA\Property(property="statusCode", type="integer", example=401),
     *              @OA\Property(property="status", type="string", example="error"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Failed to create token",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Failed to create token"),
     *              @OA\Property(property="statusCode", type="integer", example=500),
     *              @OA\Property(property="status", type="string", example="error"),
     *          )
     *      )
     * )
     */

    public function signin(Request $request)
    {
        $requestData = $request->only(['Username', 'Password']);
        $response = $this->userService->signIn($requestData);

        return response()->json($response);
    }


    /**
     * @OA\Post(
     *      path="/user-management/users/sign-up",
     *      operationId="signup",
     *      tags={"User Management"},
     *      summary="Sign up new user",
     *      description="Create a new user account",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"Username", "Password"},
     *              @OA\Property(property="Username", type="string", example="john_doe"),
     *              @OA\Property(property="Password", type="string", format="password", example="password123"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User successfully registered",
     *
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *
     *      ),
     * )
     */
    public function signup(Request $request)
    {
        $requestData = $request->only(['Username', 'Fullname', 'Password']);
        $response = $this->userService->signUp($requestData);

        return response()->json($response);
    }
}
