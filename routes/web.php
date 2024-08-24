<?php

use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\LeaveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/new-employees', [EmployeeController::class, 'newEmployees'])->name('employees.newEmployees');
Route::resource('/employees', EmployeeController::class);

Route::get('/leave-balances', [LeaveController::class, 'leaveBalances'])->name('leaves.leaveBalances');
Route::resource('/leaves', LeaveController::class);
