<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/employees/export', [EmployeeController::class, 'downloadExcel']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(EmployeeController::class)->group(function() {
    Route::get('/employees', 'index');
    Route::get('/employees/{id}','show');
    Route::get('/employees/search/{name}', 'search');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(EmployeeController::class)->group(function() {

        Route::post('/employees', 'store');
        Route::put('/employee/{id}', 'update');
        Route::delete('/employees/{id}', 'destroy');
        // Route::get('/employees/export', 'downloadExcel');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/attendance/{employeeId}', [AttendanceController::class, 'index']);
    Route::post('/arrive/{employeeId}', [AttendanceController::class, 'checkIn']);
    Route::post('/leave/{employeeId}', [AttendanceController::class, 'checkOut']);
});

