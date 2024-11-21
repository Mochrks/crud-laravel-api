<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Utils\ResponseUtils;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return ResponseUtils::errorResponse('Unauthorized: Missing token', 401);
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();
            $request->merge(['user' => $user]);
        } catch (Exception $e) {
            return ResponseUtils::errorResponse('Unauthorized: Token invalid', 401);
        }

        return $next($request);
    }
}
