<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SurveyDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'FK_course_id'          =>  'required|integer|exists:courses,RECORD_id',
            'FK_teacher_id'         =>  'required|integer|exists:teachers,RECORD_id',
            'course_starts_at'      =>  'required|date_format:Y-m-d H:i:s',
            'course_ends_at'        =>  'required|date_format:Y-m-d H:i:s',
        ]);

        return $next($request);
    }
}
