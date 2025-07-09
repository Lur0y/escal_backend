<?php

namespace App\Http\Middleware;

use App\Models\SurveyModel;
use App\Services\SurveyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SurveyStateChangeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'to'                =>  'required|integer|in:2,3',
            'teacher_code'      =>  'required|string|max:4',
            'students_quantity' =>  'required|integer'
        ]);

        if ($request->to == 2) {
            $survey_service = new SurveyService;
            if (!$survey_service->surveyIsOpenable(survey: SurveyModel::find($request->survey_id))) {
                return response()->json(['message' => 'This survey cannot be open'], 410);
            }
        }
        return $next($request);
    }
}
