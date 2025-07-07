<?php

namespace App\Http\Middleware;

use App\Models\TeacherModel;
use App\Services\TeacherService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherHasPhotoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $teacher_service = new TeacherService;
        if (!$teacher_service->teacherHasPhoto(teacher: TeacherModel::find($request->teacher_id))) {
            return response()->json(['message' => 'This teacher does not have a photo'], 422);
        }
        return $next($request);
    }
}
