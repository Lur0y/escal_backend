<?php

namespace App\Services;

use App\Models\TeacherModel;
use Illuminate\Support\Collection;

class TeacherService
{
    public function getAllTeachers(): Collection
    {
        return TeacherModel::select('RECORD_id', 'teacher_name', 'worker_id')->get();
    }

    public function teacherHasPhoto(TeacherModel $teacher): bool
    {
        return $teacher->photo_path != null;
    }

    public function getTeacherPhoto(TeacherModel $teacher)
    {
        return $teacher->photo_path;
    }

    public function saveTeacherPhoto($photo, TeacherModel $teacher): int
    {
        $path = env('FILE_PHOTOS_DIR') . "/user_{$teacher->RECORD_id}_photo." . $photo->extension();
        $file = $photo;
        $file->move(dirname($path), basename($path));
        $teacher->photo_path = $path;
        $teacher->save();
        return $teacher->RECORD_id;
    }

    public function saveTeacherData($data, TeacherModel $teacher): int
    {
        $teacher->teacher_name = $data->teacher_name;
        $teacher->worker_id = $data->worker_id;
        $teacher->save();
        return $teacher->RECORD_id;
    }

    public function deleteCourse(TeacherModel $teacher): void
    {
        $teacher->delete();
    }
}
