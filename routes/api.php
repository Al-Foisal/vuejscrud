<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::post('/login', [AuthController::class, 'login']);

Route::controller(DepartmentController::class)->prefix('/department')->group(function () {
    Route::get('/', 'index');
    Route::post('/store', 'store');
    Route::post('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});

Route::controller(StudentController::class)->prefix('/student')->group(function () {
    Route::get('/', 'index');
    Route::get('/department-list', 'departmentList');
    Route::post('/store', 'store');
    Route::post('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});

Route::controller(ResultController::class)->prefix('/result')->group(function () {
    Route::get('/', 'index');
    Route::get('/student-list', 'studentList');
    Route::post('/store', 'store');
    Route::post('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();
    Auth::guard('web')->logout();

    return ['status' => 'ok', 'message' => 'Logout Successful!'];
});