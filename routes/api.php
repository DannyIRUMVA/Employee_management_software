<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

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

    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/attendance/{employeeId}', [AttendanceController::class, 'index']);
    Route::post('/check-in/{employeeId}', [AttendanceController::class, 'checkIn']);
    Route::post('/check-out/{employeeId}', [AttendanceController::class, 'checkOut']);
});

