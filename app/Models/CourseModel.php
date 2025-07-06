<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseModel extends Model
{
    protected $table = "courses";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function surveys(): HasMany
    {
        return $this->hasMany(SurveyModel::class, 'FK_course_id', 'RECORD_id');
    }
}
