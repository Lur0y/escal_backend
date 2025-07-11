<?php

namespace App\Http\Middleware;

use App\Services\DefaultAdminService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminIsLoadedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('admins')) {
            return $next($request);
        }

        $default_admin_service = new DefaultAdminService;
        if (!$default_admin_service->isDefaultAdminLoaded()) {
            return response()->json(['message' => 'Default admin has not been loaded, cannot use the system without it'], 425);
        }

        return $next($request);
    }
}
