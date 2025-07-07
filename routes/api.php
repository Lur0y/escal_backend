<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\AdminIsLoadedMiddleware;
use App\Http\Middleware\AdminIsNotLoadedMiddleware;
use App\Http\Middleware\AuthDataMiddleware;
use App\Http\Middleware\CourseDataMiddleware;
use App\Http\Middleware\CourseExistsMiddleware;
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

/* TODO:

    CRUD -> teachers
    POST -> surveys
    POST -> surveys/{survey_id}/answers/code/1234
    // A way to:
        -Open survey with teachers code
        -Close survey again with teachers code
        -Important: Never reopen surveys!
*/