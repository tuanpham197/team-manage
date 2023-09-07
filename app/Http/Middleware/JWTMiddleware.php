<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\HttpCodeEnum;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // check token expired
            auth()->userOrFail();

            return $next($request);
        } catch (TokenExpiredException|UserNotDefinedException  $exception) {
            return response([
                'message' => '401 Unauthorized',
            ], HttpCodeEnum::HTTP_UNAUTHORIZED);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response([
                'message' => $e->getMessage(),
            ], HttpCodeEnum::HTTP_FORBIDDEN);
        }
    }
}
