<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SurveyAnswerModel extends Model
{
    protected $table = "survey_answers";
    protected $primaryKey = "RECORD_id";

    const CREATED_AT = 'RECORD_created_at';
    const UPDATED_AT = 'RECORD_updated_at';

    public function survey(): BelongsTo
    {
        return $this->belongsTo(SurveyModel::class, 'FK_survey_id', 'RECORD_id');
    }

    public function surveyQuestions(): BelongsToMany
    {
        return $this->belongsToMany(SurveyQuestionModel::class, 'survey_question_survey_answer', 'FK_survey_answer_id', 'FK_survey_question_id');
    }
}
