<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Userwallet;
use App\Models\Cardauth;
use App\Models\Bankaccounts;
use App\Models\Savings;
use App\Models\Benefits;
use App\Models\Transactionhistory;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserwalletController extends BaseController
{

    public function showBenefitsList(){

        // $showLists = DB::select( DB::raw("SELECT bendatas.id,  bendatas.name, bendatas.code, bendatas.min, bendatas.image, bendatas.leastminimum
        // FROM bendatas
        // INNER JOIN bensubdatas ON bendatas.id=bensubdatas.bendata_id;"));

        $showLists = DB::select( DB::raw("SELECT selectedsource  FROM bendatas where id=1"));

        $bodies = json_encode($showLists[0]);
        $ourBodies = json_decode($bodies);
        $ourSelected = json_decode($ourBodies->selectedsource);
        // print_r(gettype($ourSelected));
        // return response()->json([
        //     'benIe' => $showLists
        // ]);
    }

    public function createWallet(Request $request){
        $input = $request->all();
        $created =   Userwallet::create($input);
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

    public function getUserwallet(Request $request,$id) {
        $Userwallet = Userwallet::findOrFail($id);

        if($Userwallet){
            return response()->json([
                'userData' => $Userwallet,
                'message' => 'User fecthed successfully',
                'status' => 'success'
            ]);
        }
        else {
            return response()->json([
                'message' => 'unable to fetch wallet',
                'status' => 'failed'
            ]);
        }

    }

    public function updateUserwallet(Request $request){


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
                $Userwallet = Userwallet::findOrFail($id);
                return response()->json([
                    'userData' => $Userwallet,
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
    $account_number = $request->account_number;

    $getDetails= DB::select( DB::raw("SELECT * FROM bankaccounts WHERE account_number = :account_number"), array(
        'account_number' => $account_number,
      ));

      if(count($getDetails) != 0){
            return response()->json([
                'message' => 'account number already exists'
            ],400);
      }
else {
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
        ],400);
    }
}

}


public function getSavedRecipient(Request $request,$email){
    $getDetails= DB::select( DB::raw("SELECT * FROM bankaccounts WHERE userMail = :email"), array(
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

public function deleteSavings(Request $request,$id){
    $deleteSavings= DB::delete( DB::raw("DELETE FROM savings WHERE id = :id"), array(
        'id' => $id,
      ));

      if ($deleteSavings) {
        return response()->json([
            'message'=> 'success',
           
        ],200);
    }else {
        return response()->json([
            'message' => 'error'
        ],404);
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

public function isHaveWallet(Request $request,$email){

    $getStatus = DB::select( DB::raw("SELECT * FROM userwallets WHERE userMail = :userMail"), array(
        'userMail' => $email,
      ));

      if(count($getStatus) == 0){
        return response()->json([
            'message' => 'you haven\'t created a wallet yet',
            'status' =>'create',

        ]);
      }else {
        return response()->json([
            'message' => 'wallet exists',
            'status' => 'continue',
            'userId' => $getStatus[0]->id
        ]);
      }
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
    ],200);
  }
else {
    return response()->json([
        'message' => 'failed',
    ],400);
}

}

public function saveTransactions(Request $request){
        $input = $request->all();
      $created = Transactionhistory::create($input);

      if ($created) {
        return response()->json([
            'status' => 'success',
            'message' => 'Transaction history created'
        ],200);
      }
      else {
        return response()->json([
            'status' => 'failed',
            'message' => 'Transaction history not created'
        ],400);
      }
}


public function getAllTransactionsHistory(Request $request,$email){
    $getDetails= DB::select( DB::raw("SELECT * FROM  transactionhistories WHERE userMail = :email"), array(
        'email' => $email,
      ));

      if(count($getDetails) == 0){
            return response()->json([
                'message' => 'Transaction history is empty',
                'status' => 'empty'
            ],400);
      } else {
        return response()->json([
            'message' => 'Transaction history found',
            'status' => 'success',
            'data' => $getDetails,
        ],200);
      }
}


public function getTransactionHistoryByType(Request $request,$email,$categoryType){
    $getDetails= DB::select( DB::raw("SELECT * FROM  transactionhistories WHERE userMail = :email AND categoryType =:categoryType"), array(
        'email' => $email,'categoryType' => $categoryType
      ));

      if(count($getDetails) == 0){
        return response()->json([
            'message' => 'Transaction history is empty',
            'status' => 'empty'
        ]);
  } else {
    return response()->json([
        'message' => 'Transaction history found',
        'status' => 'success',
        'data' => $getDetails,
    ]);
  }

}

public function updateSavings(Request $request){
    $status = $request->status;
    $id = $request->id;

    $result = DB::update(DB::raw("update savings set status=:status where id=:id"),array('status'=>$status,'id'=>$id));
    // return response()->json(['success'=>'done']);
        if ($result) {
           return response()->json([
               'message'=> 'status updated',
               'success' => 'success'
           ],200);
       }

       else{
        return response()->json([
            'message'=> 'failed to update status',
            'success' => 'failed'
        ],400);
       }
}

public function updateVault(Request $request){


    $id = $request->id;
    $interest = $request->interest;
    $payback_date = $request->payback_date;
    $amount = $request->amount;
    $title = $request->title;

    $source = $request->source;
    $userMail = $request->userMail;

    $calculatedBenefits = $request->calculatedBenefits;
    $howoften = $request->howoften;

    $result = DB::update(DB::raw("update savings set interest=:interest,
    payback_date=:payback_date,amount=:amount,title=:title,
    source=:source,userMail=:userMail,
    calculatedBenefits=:calculatedBenefits,
    howoften=:howoften where id=:id"),array('interest'=>$interest,
    'payback_date'=>$payback_date
     ,'amount'=>$amount,'title'=>$title,'source'=>$source,
     'userMail'=>$userMail,
     'calculatedBenefits'=>$calculatedBenefits,
     'howoften'=>$howoften,
     'id'=>$id));

 
    // return response()->json(['success'=>'done']);
        if ($result) {
           return response()->json([
               'message'=> 'savings updated',
               'success' => 'success'
           ],200);
       }

       else{
        return response()->json([
            'message'=> 'failed to update status',
            'success' => 'failed'
        ],400);
       }
}


}
