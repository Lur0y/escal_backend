<?php

namespace App\Services;

use App\Models\SurveyAnswerModel;
use App\Models\SurveyModel;
use App\Models\SurveyQuestionModel;
use Illuminate\Support\Facades\DB;

class SurveyService
{
    public function getSurveyQuestions(SurveyModel $survey)
    {
        $questions = SurveyQuestionModel::all();
        return $questions;
    }
    public function surveyIsOpenable(SurveyModel $survey): bool
    {
        return $survey->FK_survey_status_id == 1;
    }

    public function saveSurveyData($data, SurveyModel $survey): int
    {
        $survey->FK_course_id = $data->FK_course_id;
        $survey->FK_teacher_id = $data->FK_teacher_id;
        $survey->course_starts_at = $data->course_starts_at;
        $survey->course_ends_at = $data->course_ends_at;
        $survey->FK_survey_status_id = 1;
        $survey->teacher_code = mt_rand(1000, 9999);
        $survey->save();
        return $survey->RECORD_id;
    }

    public function updateState($to, $code, $quantity, SurveyModel $survey): bool
    {
        if ($survey->teacher_code != $code) {
            return false;
        }

        switch ($to) {

            case 2:
                for ($i = 0; $i < $quantity; $i++) {
                    $answer = new SurveyAnswerModel;
                    $exists = true;
                    while ($exists) {
                        $answer->student_code = mt_rand(1000, 9999);
                        $exists = SurveyAnswerModel::whereHas('survey', function ($query) {
                            $query->where('FK_survey_status_id', 2);
                        })->where('student_code', $answer->student_code)->exists();
                    }
                    $answer->FK_survey_id = $survey->RECORD_id;
                    $answer->save();
                }
                break;

            case 3:
                $answers_ids = SurveyAnswerModel::whereHas('survey', function ($query) use ($survey) {
                    $query->where('RECORD_id', $survey->RECORD_id);
                })->where('is_fulfilled', 0)->pluck('RECORD_id');

                DB::table('survey_question_survey_answer')
                    ->whereIn('FK_survey_answer_id', $answers_ids)
                    ->delete();

                SurveyAnswerModel::whereIn('RECORD_id', $answers_ids)->delete();
                break;

            default:
                return false;
                break;
        }

        $survey->FK_survey_status_id = $to;
        $survey->save();
        return true;
    }

    public function getTeacherCode(SurveyModel $survey): string
    {
        return $survey->teacher_code;
    }

    public function getStudentCodes(SurveyModel $survey): array
    {
        $student_codes = [];
        foreach ($survey->surveyAnswers as $answer) {
            array_push($student_codes, $answer->student_code);
        }
        return $student_codes;
    }

    public function saveAnswerData($student_code, $answers, $comments, SurveyModel $survey): bool
    {
        $query =  SurveyAnswerModel::whereHas('survey', function ($query) use ($survey) {
            $query->where('RECORD_id', $survey->RECORD_id)->where('FK_survey_status_id', 2);
        })->where('student_code', $student_code)->where('is_fulfilled', 0);
        $query2 = clone $query;

        if (!$query->exists()) {
            return false;
        }

        $answer = $query2->first();
        $answer->is_fulfilled = 1;
        $answer->comments = $comments;
        $answer->save();

        $syncData = [];
        foreach ($answers as $item) {
            $syncData[$item['question_id']] = ['answer_value' => $item['answer_value']];
        }
        $answer->surveyQuestions()->sync($syncData);

        return true;
    }
}
