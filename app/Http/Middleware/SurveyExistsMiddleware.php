<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SurveyExistsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->mergeIfMissing(['survey_id' => $request->route('survey_id')]);
        $request->validate([
            'survey_id'    =>      'required|integer|exists:surveys,RECORD_id'
        ]);

        return $next($request);
    }
}
