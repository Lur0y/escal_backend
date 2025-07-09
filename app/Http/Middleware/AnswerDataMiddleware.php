<?php

namespace App\Http\Middleware;

use App\Models\SurveyQuestionModel;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AnswerDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->validate([
            'student_code'              =>  'required|string|max:4',
            'comments'                  =>  'nullable|string',
            'answers'                   =>  'required|array',
            'answers.*.answer_value'    =>  'required|integer|min:0|max:10',
            'answers.*.question_id'     =>  'required|integer|exists:survey_questions,RECORD_id|distinct'
        ]);

        $expectedQuestionIds = SurveyQuestionModel::pluck('RECORD_id')->sort()->values();
        $submittedQuestionIds = collect($request->answers)
            ->pluck('question_id')
            ->sort()
            ->values();
        if (
            $expectedQuestionIds->diff($submittedQuestionIds)->isNotEmpty() ||
            $submittedQuestionIds->diff($expectedQuestionIds)->isNotEmpty()
        ) {
            return response()->json([
                'message' => 'There are missing questions',
            ], 422);
        }

        return $next($request);
    }
}
