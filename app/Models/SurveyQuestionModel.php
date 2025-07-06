<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyQuestionModel extends Model
{
    protected $table = "survey_questions";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function surveyAnswers(): BelongsToMany
    {
        return $this->belongsToMany(SurveyAnswerModel::class, 'survey_question_survey_answer', 'FK_survey_question_id', 'FK_survey_answer_id');
    }
}
