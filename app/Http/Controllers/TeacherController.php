<?php

namespace App\Http\Controllers;

use App\Models\TeacherModel;
use App\Services\TeacherService;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function show(TeacherService $teacher_service)
    {
        return response()->json($teacher_service->getAllTeachers(), 200);
    }

    public function showPhoto($teacher_id, TeacherService $teacher_service)
    {
        return response()->file($teacher_service->getTeacherPhoto(teacher: TeacherModel::find($teacher_id)));
    }

    public function store(Request $request, TeacherService $teacher_service)
    {
        $id = $teacher_service->saveTeacherData(data: $request, teacher: new TeacherModel);
        return response()->json(['id' => $id], 201);
    }

    public function update($teacher_id, Request $request, TeacherService $teacher_service)
    {
        $teacher_service->saveTeacherData(data: $request, teacher: TeacherModel::find($teacher_id));
        return response()->json([], 204);
    }

    public function updatePhoto($teacher_id, Request $request, TeacherService $teacher_service)
    {
        $teacher_service->saveTeacherPhoto(photo: $request->file('photo'), teacher: TeacherModel::find($teacher_id));
        return response()->json([], 204);
    }

    public function destroy($teacher_id, TeacherService $teacher_service)
    {
        $teacher_service->deleteCourse(TeacherModel::find($teacher_id));
        return response()->json([], 204);
    }
}
