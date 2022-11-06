<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SchoolController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('product', [ProductController::class, 'getProduct']);

Route::get('product/{id}', [ProductController::class, 'singleProduct']);

Route::post('/adminregister', [AdminAuthController::class, 'register']);

Route::post('/adminlogin', [AdminAuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::put('product/{id}', [ProductController::class, 'updateProduct']);

    Route::delete('product/{id}', [ProductController::class, 'deleteProduct']);

    Route::post('product', [ProductController::class, 'addProduct']);

    Route::post('/adminlogout', [AdminAuthController::class, 'logout']);
});

Route::post('class', [SchoolController::class, 'addClass']);

Route::post('student', [SchoolController::class, 'addStudent']);

Route::get('class/{id}', [SchoolController::class, 'getStudents']);

Route::get('student/{id}', [SchoolController::class, 'getClasses']);
