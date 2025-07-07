<?php

namespace App\Http\Middleware;

use App\Services\DefaultAdminService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIsNotLoadedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $default_admin_service = new DefaultAdminService;
        if ($default_admin_service->isDefaultAdminLoaded()) {
            return response()->json(['message' => 'Default admin has been already loaded'], 410);
        }

        return $next($request);
    }
}
