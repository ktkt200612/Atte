<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


//Route::get('/register', [AuthController::class, 'create']);
//Route::post('/register/store', [AuthController::class, 'store']);
//Route::get('/login/index', [AuthController::class, 'loginindex']); 
//Route::post('/login', [AuthController::class, 'login']); 
Route::group(['middleware' => ['auth']], function(){
    //Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/index', [AttendanceController::class, 'index']);
    Route::post('/attendancein', [AttendanceController::class, 'attendancein']);
    Route::post('/attendanceout', [AttendanceController::class, 'attendanceout']);
    Route::get('/date', [AttendanceController::class, 'dateindex']);
    Route::post('/restin', [RestController::class, 'restin']);
    Route::post('/restout', [RestController::class, 'restout']);
});
