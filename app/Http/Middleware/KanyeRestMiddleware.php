<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KanyeRestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()) {
            return response()->json(['error' => 'Unauthorized. Not logged in.'], 401);
        }

        if (!$request->bearerToken()) {
            return response()->json(['error' => 'Unauthorized. Bearer token not provided.'], 401);
        }

        if($request->bearerToken() !== Auth::user()->api_token){
            return response()->json(['error' => 'Unauthorized. Invalid bearer token.'], 401);
        }

        return $next($request);
    }
}
