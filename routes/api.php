<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\AdminIsLoadedMiddleware;
use App\Http\Middleware\AdminIsNotLoadedMiddleware;
use App\Http\Middleware\AnswerDataMiddleware;
use App\Http\Middleware\AuthDataMiddleware;
use App\Http\Middleware\CourseDataMiddleware;
use App\Http\Middleware\CourseExistsMiddleware;
use App\Http\Middleware\SurveyDataMiddleware;
use App\Http\Middleware\SurveyExistsMiddleware;
use App\Http\Middleware\SurveyStateChangeMiddleware;
use App\Http\Middleware\TeacherDataMiddleware;
use App\Http\Middleware\TeacherExistsMiddleware;
use App\Http\Middleware\TeacherHasPhotoMiddleware;
use App\Http\Middleware\TeacherPhotoMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admins')->controller(AdminController::class)->group(function () {

    Route::post('default', 'loadDefaultAdmin')->middleware([
        AdminIsNotLoadedMiddleware::class
    ]);
});

Route::prefix('tokens')->controller(TokenController::class)->group(function () {

    Route::post('/', 'createToken')->middleware([
        AdminIsLoadedMiddleware::class,
        AuthDataMiddleware::class
    ]);
});

Route::prefix('courses')->controller(CourseController::class)->group(function () {

    Route::get('/', 'show')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum'
    ]);
    Route::post('/', 'store')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        CourseDataMiddleware::class
    ]);
    Route::put('/{course_id}', 'update')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        CourseExistsMiddleware::class,
        CourseDataMiddleware::class
    ]);
    Route::delete('/{course_id}', 'destroy')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        CourseExistsMiddleware::class
    ]);
});

Route::prefix('teachers')->controller(TeacherController::class)->group(function () {

    Route::get('/', 'show')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum'
    ]);
    Route::get('/{teacher_id}/photo', 'showPhoto')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        TeacherExistsMiddleware::class,
        TeacherHasPhotoMiddleware::class
    ]);
    Route::post('/', 'store')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        TeacherDataMiddleware::class
    ]);
    Route::put('/{teacher_id}', 'update')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        TeacherExistsMiddleware::class,
        TeacherDataMiddleware::class
    ]);
    Route::post('/{teacher_id}/photo', 'updatePhoto')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        TeacherExistsMiddleware::class,
        TeacherPhotoMiddleware::class
    ]);
    Route::delete('/{teacher_id}', 'destroy')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        TeacherExistsMiddleware::class
    ]);
});

Route::prefix('surveys')->controller(SurveyController::class)->group(function () {

    Route::post('/', 'store')->middleware([
        AdminIsLoadedMiddleware::class,
        'auth:sanctum',
        SurveyDataMiddleware::class
    ]);

    Route::patch('/{survey_id}/state', 'updateState')->middleware([
        AdminIsLoadedMiddleware::class,
        SurveyExistsMiddleware::class,
        SurveyStateChangeMiddleware::class
    ]);

    Route::post('/{survey_id}/answers', 'storeAnswer')->middleware([
        AdminIsLoadedMiddleware::class,
        SurveyExistsMiddleware::class,
        AnswerDataMiddleware::class
    ]);
});
