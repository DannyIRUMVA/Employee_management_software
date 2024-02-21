<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;

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
        Route::post('/employees/{id}', 'update');
        Route::delete('/employee/{id}', 'destroy');

    });
});

