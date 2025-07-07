<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherExistsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->mergeIfMissing(['teacher_id' => $request->route('teacher_id')]);
        $request->validate([
            'teacher_id'    =>      'required|integer|exists:teachers,RECORD_id'
        ]);

        return $next($request);
    }
}
