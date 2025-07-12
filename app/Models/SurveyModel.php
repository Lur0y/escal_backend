<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyModel extends Model
{
    use SoftDeletes;

    protected $table = "surveys";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';
    const DELETED_AT = 'RECORD_deleted_at';

    public function course(): BelongsTo
    {
        return $this->belongsTo(CourseModel::class, 'FK_course_id', 'RECORD_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(TeacherModel::class, 'FK_teacher_id', 'RECORD_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(SurveyStatusModel::class, 'FK_survey_status_id', 'RECORD_id');
    }

    public function surveyAnswers(): HasMany
    {
        return $this->hasMany(SurveyAnswerModel::class, 'FK_survey_id', 'RECORD_id');
    }
}
