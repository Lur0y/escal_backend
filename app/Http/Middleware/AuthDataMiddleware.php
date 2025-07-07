<?php

namespace App\Http\Middleware;

use App\Services\TokenService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'username'      =>  'required|string|max:50',
            'pwd'           =>  'required|string|max:50'
        ]);

        $token_service = new TokenService;

        if (!$token_service->isPwdOk(username: $request->username, pwd: $request->pwd)) {
            return response()->json([
                'message'   =>      'Username or password incorrect'
            ], 401);
        }

        return $next($request);
    }
}
