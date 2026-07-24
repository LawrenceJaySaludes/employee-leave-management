<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LeaveTypeController;
use App\Http\Controllers\Api\LeaveRequestController;
use App\Http\Controllers\Api\DashboardController;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);
Route::get('/test', [TestController::class, 'index']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

    // Anyone logged in can view employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::get('/leave-types', [LeaveTypeController::class, 'index']);
    Route::get('/leave-types/{id}', [LeaveTypeController::class, 'show']);
    Route::get('/leave-requests', [LeaveRequestController::class, 'index']);
    Route::post('/leave-requests', [LeaveRequestController::class, 'store']);
    Route::get('/leave-requests/{id}', [LeaveRequestController::class, 'show']);
    Route::put('/leave-requests/{id}', [LeaveRequestController::class, 'update']);
    Route::delete('/leave-requests/{id}', [LeaveRequestController::class, 'destroy']);
    Route::get('/my-leaves', [LeaveRequestController::class, 'myLeaves']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/employee/dashboard', [DashboardController::class, 'employeeDashboard']);

    // Admin only
    Route::middleware('admin')->group(function () {

        Route::post('/employees', [EmployeeController::class, 'store']);
        Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);
        Route::post('/leave-types', [LeaveTypeController::class, 'store']);
        Route::put('/leave-types/{id}', [LeaveTypeController::class, 'update']);
        Route::delete('/leave-types/{id}', [LeaveTypeController::class, 'destroy']);
        Route::get('/admin/leave-requests', [LeaveRequestController::class, 'adminIndex']);
        Route::put('/leave-requests/{id}/approve', [LeaveRequestController::class, 'approve']);
        Route::put('/leave-requests/{id}/reject', [LeaveRequestController::class, 'reject']);

    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

});
