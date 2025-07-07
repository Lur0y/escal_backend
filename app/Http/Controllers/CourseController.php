<?php

namespace App\Http\Controllers;

use App\Models\CourseModel;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(CourseService $course_service)
    {
        return response()->json($course_service->getAllCourses(), 200);
    }

    public function store(Request $request, CourseService $course_service)
    {
        $id = $course_service->saveCourseData(data: $request, course: new CourseModel);
        return response()->json(['id' => $id], 201);
    }

    public function update($course_id, Request $request, CourseService $course_service)
    {
        $course_service->saveCourseData(data: $request, course: CourseModel::find($course_id));
        return response()->json([], 204);
    }

    public function destroy($course_id, CourseService $course_service)
    {
        $course_service->deleteCourse(CourseModel::find($course_id));
        return response()->json([], 204);
    }
}
