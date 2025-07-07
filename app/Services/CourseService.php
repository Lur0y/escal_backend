<?php

namespace App\Services;

use App\Models\CourseModel;
use Illuminate\Support\Collection;

class CourseService
{
    public function getAllCourses(): Collection
    {
        return CourseModel::select('RECORD_id', 'course_name')->get();
    }

    public function saveCourseData($data, CourseModel $course): int
    {
        $course->course_name = $data->course_name;
        $course->save();
        return $course->RECORD_id;
    }

    public function deleteCourse(CourseModel $course): void
    {
        $course->delete();
    }
}
