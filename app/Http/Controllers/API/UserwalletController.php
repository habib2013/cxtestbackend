<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\userWallet;
use App\Models\Cardauth;
use App\Models\Bankaccounts;
use App\Models\Savings;
use App\Models\Benefits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserwalletController extends BaseController
{

    public function createWallet(Request $request){
        $input = $request->all();
        $created =   userWallet::create($input);
            $currentDate = rand(1,150000000000);
        $userFirstName = $input['first_name'];
        // $userID = $input['id'];

        $userLastName = $input['last_name'];

        $userMail = $request->userMail;
        $getID = DB::select( DB::raw("SELECT id FROM userwallets WHERE userMail = :userMail"), array(
            'userMail' => $userMail,
          ));

        $NewuserID = $getID[0]-> id;

        if ($created) {
        return response()->json([
            'message' => 'Wallet created successfully',
            'userID' => $NewuserID,
           'getWalletToken' => $currentDate.'_'.$userFirstName.'_'.$userLastName,
        ],200);
        }
        else{
        return response()->json([
            'message' => 'Unable to create wallet'
        ],404);
        }

    }

    public function getUserWallet(Request $request,$id) {
        $userWallet = userWallet::findOrFail($id);
        return response()->json([
            'userData' => $userWallet,
            'message' => 'User fecthed successfully',
        ]);
    }

    public function updateUserWallet(Request $request){


        $input = $request->all();

        $id = $input['id'];
        $first_name = $input['first_name'];
        $last_name = $input['last_name'];
        $mobile = $input['mobile'];
        $bvn = $input['bvn'];
        $userMail = $input['userMail'];
        $walletBalance = $input['walletBalance'];


        // $result = DB::update(DB::raw("update userwallets set walletBalance=:walletBalance where id=:id"),
        // array('amount'=>$amount,'id'=>$id,));

        $result = DB::update(DB::raw("update userwallets set first_name=:first_name,last_name=:last_name,mobile=:mobile,bvn=:bvn,userMail=:userMail,walletBalance=:walletBalance where id=:id"),
        array('first_name'=>$first_name,'id'=>$id,'last_name'=>$last_name,'mobile'=>$mobile,'bvn'=>$bvn,'userMail'=>$userMail,'walletBalance'=>$walletBalance,));




            if($result){
                $userWallet = userWallet::findOrFail($id);
                return response()->json([
                    'userData' => $userWallet,
                    'message' => 'User fecthed successfully',
                ]);
            }
            else {
                return response()->json([
                    'message' => 'failed'
                ]);
            }
    }

public function saveReceipientData(Request $request){

    $input = $request->all();

    $res_created = Bankaccounts::create($input);

    if($res_created){
        return response()->json([
            'message'=> 'success'
        ],200);
        }
    else {
        return response()->json([
            'message'=> 'falied'
        ],200);
    }

}


public function saveTransactionCard(Request $request){
    $input = $request->all();

    $res_created = Cardauth::create($input);

    if($res_created){
        return response()->json([
            'message'=> 'success'
        ],200);
        }
    else {
        return response()->json([
            'message'=> 'falied'
        ],200);
    }




}

public function showSavedCards(Request $request,$email){

    $getDetails= DB::select( DB::raw("SELECT * FROM cardauths WHERE email = :email"), array(
        'email' => $email,
      ));

      if ($getDetails) {
          return response()->json([
              'message'=> 'success',
              'data' => $getDetails,
          ],200);
      }else {
          return response()->json([
              'message' => 'error'
          ],404);
      }

}

public function calculateInterestWithDate(Request $request){

    $mytime = Carbon::now();
    $nextTenDays = Carbon::now()->addDays(10);




    // echo $mytime->toDateTimeString();

}


public function savingsVault(Request $request){
        $input = $request->all();

       $saved =  Savings::create($input);
        if ($saved) {
           return response()->json([
               'status' => 'saved',
               'message'=> 'saved successfully'
           ],200);
        }
        else {
            return response()->json([
                'message'=> 'Error'
            ],400);
        }
}

public function getTotalSavings(Request $request,$email){
    $getDetails= DB::select( DB::raw("SELECT * FROM savings WHERE userMail = :email"), array(
        'email' => $email,
      ));

       if ($getDetails) {
         return response()->json([
               'message'=> 'success',
             'data' => $getDetails
         ],200);
          }else {
         return response()->json([
              'message' => 'error'
           ],404);
       }
}

public function saveBenefits(Request $request){

    $input = $request->all();
  $created =  Benefits::create($input);

  if ($created) {
    return response()->json([
        'message' => 'success',
    ]);
  }


}


}
