<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserdashboardController;
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

// Route::get('/dashboard', function () {
//     return view('userdashboard');
// });


Route::post('login', [LoginController::class, 'login']);
Route::get('dashboard', [UserdashboardController::class, 'dashboard']);

Route::get('savings', [UserdashboardController::class, 'savings']);

Route::get('benefits', [UserdashboardController::class, 'benefits']);
Route::get('editbenefits', [UserdashboardController::class, 'editbenefits']);

// Route::middleware(['auth:sanctum', 'verified'])->get('/uhome', function () {
//     return view('udashboard');
// })->name('home');
