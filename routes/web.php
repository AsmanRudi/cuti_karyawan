<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'ADMIN') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('employee.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Employee\LeaveRequestController;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/users/create-admin', [UserController::class, 'createAdmin'])->name('users.create-admin');
    Route::post('/users/store-admin', [UserController::class, 'storeAdmin'])->name('users.store-admin');

    Route::resource('employees', EmployeeController::class);
    Route::resource('leavetypes', LeaveTypeController::class);
    
    Route::get('approvals', [LeaveApprovalController::class, 'index'])->name('approvals.index');
    Route::get('approvals/{leaveRequest}', [LeaveApprovalController::class, 'show'])->name('approvals.show');
    Route::put('approvals/{leaveRequest}', [LeaveApprovalController::class, 'update'])->name('approvals.update');
    
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['auth', 'verified', 'employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', function () {
        return view('employee.dashboard');
    })->name('dashboard');
    
    Route::resource('leave-requests', LeaveRequestController::class)->only(['index', 'create', 'store', 'destroy']);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
