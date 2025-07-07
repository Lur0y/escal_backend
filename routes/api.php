<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TokenController;
use App\Http\Middleware\AdminIsLoadedMiddleware;
use App\Http\Middleware\AdminIsNotLoadedMiddleware;
use App\Http\Middleware\AuthDataMiddleware;
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

    Route::get('/', 'show')->middleware([AdminIsLoadedMiddleware::class, 'auth:sanctum']);
});

/* TODO:

    CRUD -> courses
    CRUD -> teachers
    POST -> surveys
    POST -> surveys/{survey_id}/answers/code/1234
    // A way to:
        -Open survey with teachers code
        -Close survey again with teachers code
        -Important: Never reopen surveys!
*/