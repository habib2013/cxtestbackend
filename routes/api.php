<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\UserwalletController;
use App\Models\Userwallet;
use App\Mail\WelcomeMail;
use DB as DBS;
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

Route::get('sendMail/{id}', function ($id) {

    $subscriber = Userwallet::findOrFail($id);

    $userId = $id;
    $getMail = DBS::select( DBS::raw("SELECT userMail FROM userwallets WHERE id = :userId"), array(
        'userId' => $userId,
      ));

    $NewuserMail = $getMail[0]->userMail;

  //  Mail::to($subscriber)->send(new WelcomeMail($subscriber));
    // Mail::to(['alert@capitalx.email'])->send(new Hello($subscriber));
        $mailer = 'tayooladosu9@gmail.com';
       Mail::to([$NewuserMail])->send(new WelcomeMail($subscriber));

    // return view('confirmation');
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::post('saveToHasWallet', [RegisterController::class, 'saveToHasWallet']);
Route::get('/', [RegisterController::class, 'homePage']);
Route::get('/verifyReference/{reference}', [RegisterController::class, 'verifyReference']);
Route::get('/getUserData/{id}', function ($id) {
   $userData = User::findOrFail($id);
   return response()->json([
    'data' => $userData
], 201);
});

Route::get('checkpin/{userMail}',[UserwalletController::class,'checkpin']);

Route::post('createWallet',[UserwalletController::class,'createWallet']);
Route::post('updateUserWallet',[UserwalletController::class,'updateUserWallet']);
Route::post('saveReceipientData',[UserwalletController::class,'saveReceipientData']);
Route::post('saveTransactionCard',[UserwalletController::class,'saveTransactionCard']);
Route::post('savingsVault',[UserwalletController::class,'savingsVault']);
Route::post('saveBenefits',[UserwalletController::class,'saveBenefits']);

Route::post('createpin',[UserwalletController::class,'createpin']);


Route::post('deleteSavings/{id}',[UserwalletController::class,'deleteSavings']);

Route::post('saveTransactions',[UserwalletController::class,'saveTransactions']);
Route::post('updateSavings',[UserwalletController::class,'updateSavings']);
Route::post('updateVault',[UserwalletController::class,'updateVault']);

Route::get('getTotalSavings/{email}',[UserwalletController::class,'getTotalSavings']);
Route::get('calculateInterestWithDate',[UserwalletController::class,'calculateInterestWithDate']);
Route::get('getUserWallet/{id}',[UserwalletController::class,'getUserWallet']);
Route::get('showSavedCards/{email}',[UserwalletController::class,'showSavedCards']);
Route::get('getSavedRecipient/{email}',[UserwalletController::class,'getSavedRecipient']);
Route::get('isHaveWallet/{email}',[UserwalletController::class,'isHaveWallet']);
Route::get('getAllTransactionsHistory/{email}',[UserwalletController::class,'getAllTransactionsHistory']);
Route::get('getTransactionHistoryByType/{email}/{categoryType}',[UserwalletController::class,'getTransactionHistoryByType']);
Route::get('showBenefitsList',[UserwalletController::class,'showBenefitsList']);



