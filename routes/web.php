<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function(){
    Route::get('/index', [AttendanceController::class, 'index']);
    Route::post('/attendancein', [AttendanceController::class, 'attendancein']);
    Route::post('/attendanceout', [AttendanceController::class, 'attendanceout']);
    Route::get('/date', [AttendanceController::class, 'dateindex']);
    Route::post('/date', [AttendanceController::class, 'otherday']);
    Route::post('/restin', [RestController::class, 'restin']);
    Route::post('/restout', [RestController::class, 'restout']); 
});
