<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Haswallet;
use App\Models\Cardauth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        // return $this->sendResponse( 'User register successfully.');
        return response()->json([
               'User Registered successfully.'
          ], 201);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
           $userToken =  $success['token']['token'];
            $success['name'] =  $user->name;
            $success['id']  = $user->id;
            // return $this->sendResponse($success['name'], $userToken,'User login successfully.');



            return response()->json([
              'name' =>  $success['name'],
              'userID' => $success['id'] ,
               'userToken' =>  $userToken,

                'message' => 'User login successfully.'
            ], 201);
        }
        else{
            // return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
            return response()->json([
                'Username or password Incorrect',

                  'message' => 'User login Failed!!.'
              ], 404);
        }
    }


    public function saveToHasWallet(Request $request){

        $input = $request->all();

        $haswallet = Haswallet::create($input);
        if($haswallet){

        }

        return response()->json([
              'message' => 'Successfully Saved'
          ], 201);

    }

    public function homePage(Request $request){
            return response()->json([
                'message'=> 'Welcome to Homepage'
            ], 201);
    }

public function verifyReference($reference){
    $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/".$reference,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_0535a7f299f9f273c4a9a3b7fdbd888e50c5e4f8",
      "Cache-Control: no-cache",
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

  if ($err) {
    print_r('they are not equaal');
    print("cURL Error #:" . $err);
    // return response()->json([
    //     'message' => $err
    // ]);
  } else {
    $vooF =  json_decode($response);

    if($vooF->status == true){
            $authcode = $vooF->data->authorization;
            $customercode = $vooF->data->customer;
        // Haswallet::create([
        //     'id' => 3,
        //     'bleyt_id' => $vooF->data->id,
        //     'userID' => 9,
        // ]);

        Cardauth::create([
            'email' => $customercode->email,
            'authorization_code' => $authcode->authorization_code,
            'bin' => $authcode->bin,
            'last4' => $authcode->last4,
            'exp_month' => $authcode->exp_month,
            'exp_year' => $authcode->exp_year,
            'channel'=> $authcode->channel,
            'card_type' => $authcode->card_type,
            'bank' => $authcode->bank,
            'country_code'=> $authcode->country_code,
            'reusable' => $authcode->reusable,
            'signature' => $authcode->signature,
            'account_name' =>'none'

        ]);
        print_r($vooF);
                 

    } else {
        print_r('unable to print');
    }

 
  }
}

  
}
