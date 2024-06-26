<?php

use App\Http\Controllers\employeeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/employees',[employeeController::class,'index'])->name('employees.index');
// Route::get('/employees/create',[employeeController::class,'create'])->name('employees.create');
// Route::post('/employees',[employeeController::class,'store'])->name('employees.store');
// Route::get('/employees/{employee}/edit',[employeeController::class,'edit'])->name('employees.edit');
// Route::put('/employees/{employee}',[employeeController::class,'update'])->name('employees.update');
// Route::delete('/employees/{employee}',[employeeController::class,'destroy'])->name('employees.destroy');

Route::resource('employees', employeeController::class);
