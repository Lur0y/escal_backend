<?php

namespace App\Http\Controllers;

use App\Models\SurveyModel;
use App\Services\SurveyService;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function store(Request $request, SurveyService $survey_service)
    {
        $survey = new SurveyModel;
        $id = $survey_service->saveSurveyData(data: $request, survey: $survey);
        return response()->json([
            'id'            => $id,
            'teacher_code'  => $survey_service->getTeacherCode(survey: $survey)
        ], 201);
    }

    public function updateState($survey_id, Request $request, SurveyService $survey_service)
    {
        $survey = SurveyModel::find($survey_id);
        if ($survey_service->updateState(
            to: $request->to,
            code: $request->teacher_code,
            quantity: $request->students_quantity,
            survey: $survey
        )) {
            return response()->json([
                'student_codes'     => $survey_service->getStudentCodes(survey: $survey)
            ], 200);
        }
        return response()->json([
            'message' => 'Your teacher code does not match the survey\'s one, please try again'
        ], 401);
    }

    public function storeAnswer($survey_id, Request $request, SurveyService $survey_service)
    {
        if ($survey_service->saveAnswerData(
            student_code: $request->student_code,
            comments: $request->comments,
            answers: $request->answers,
            survey: SurveyModel::find($survey_id)
        )) {
            return response()->json([], 204);
        }
        return response()->json([
            'message' => 'The code does not match any student code for this survey or the survey has already been answered'
        ], 401);
    }
}
