<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if ($jwt = $request->cookie('jwt')) {
                $request->headers->set('Authorization', 'Bearer ' . $jwt);
            }
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenExpiredException) {

                if ($newToken = JWTAuth::parseToken()->refresh() instanceof Exception) {
                    return response()->json(['success' => false, 'message' => 'token Expired and change'], Response::HTTP_UNAUTHORIZED);
                }
                $request->headers->set('Authorization', 'Bearer ' . $newToken);
                cookie('jwt', $newToken);
            } else if ($e instanceof TokenInvalidException) {
                return response()->json(['success' => false, 'message' => 'token Invalid'], Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['success' => false, 'message' => 'token Not found'], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
