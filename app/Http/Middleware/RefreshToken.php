<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class RefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // First, we will try to validate the current token
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            // If token has expired, attempt to refresh it
            try {
                $newToken = JWTAuth::refresh(JWTAuth::getToken());

                // Set the new token in the authorization header
                $response = $next($request);
                $response->headers->set('Authorization', 'Bearer ' . $newToken);

                return $response;

            } catch (JWTException $e) {
                // If refresh token fails, return unauthorized response
                return response()->json(['error' => 'Token refresh failed. Please log in again.'], 401);
            }

        } catch (TokenInvalidException $e) {
            // If token is invalid, return unauthorized response
            return response()->json(['error' => 'Invalid token. Please log in again.'], 401);

        } catch (JWTException $e) {
            // If no token is provided, return unauthorized response
            return response()->json(['error' => 'Token not provided.'], 401);
        }

        // If the token is valid, proceed with the request
        return $next($request);
    }
}
