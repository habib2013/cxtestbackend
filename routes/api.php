<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\UserwalletController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('saveToHasWallet', [RegisterController::class, 'saveToHasWallet']);
Route::get('/', [RegisterController::class, 'homePage']);
Route::get('/getUserData/{id}', function ($id) {
   $userData = User::findOrFail($id);
   return response()->json([
    'data' => $userData
], 201);
});
Route::post('createWallet',[UserwalletController::class,'createWallet']);
Route::post('updateUserWallet',[UserwalletController::class,'updateUserWallet']);
Route::post('saveReceipientData',[UserwalletController::class,'saveReceipientData']);
Route::post('saveTransactionCard',[UserwalletController::class,'saveTransactionCard']);
Route::post('savingsVault',[UserwalletController::class,'savingsVault']);
Route::get('getTotalSavings/{email}',[UserwalletController::class,'getTotalSavings']);
Route::get('calculateInterestWithDate',[UserwalletController::class,'calculateInterestWithDate']);
Route::get('getUserWallet/{id}',[UserwalletController::class,'getUserWallet']);
Route::get('showSavedCards/{email}',[UserwalletController::class,'showSavedCards']);



