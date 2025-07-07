<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseExistsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->mergeIfMissing(['course_id' => $request->route('course_id')]);
        $request->validate([
            'course_id'    =>      'required|integer|exists:courses,RECORD_id'
        ]);

        return $next($request);
    }
}
