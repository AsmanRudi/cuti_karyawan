<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Employee\LeaveController as EmployeeLeaveController;
use App\Http\Controllers\Api\Admin\ApprovalController as AdminApprovalController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Employee API
    Route::prefix('employee')->group(function () {
        Route::get('/leaves', [EmployeeLeaveController::class, 'index']);
        Route::get('/leaves/quota', [EmployeeLeaveController::class, 'quota']);
        Route::post('/leaves', [EmployeeLeaveController::class, 'store']);
    });

    // Admin API
    Route::prefix('admin')->group(function () {
        Route::get('/approvals', [AdminApprovalController::class, 'index']);
        Route::put('/approvals/{id}', [AdminApprovalController::class, 'update']);
    });
});
