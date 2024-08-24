<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LeaveController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);

Route::get('/new-employees', [EmployeeController::class, 'newEmployees'])->name('newEmployees');
Route::resource('/employees', EmployeeController::class);

Route::get('/leave-balances', [LeaveController::class, 'leaveBalances'])->name('leaveBalances');
Route::resource('/leaves', LeaveController::class);
