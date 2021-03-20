<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Haswallet;
use Illuminate\Support\Facades\Auth;
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
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'password' => 'required',
        //     'c_password' => 'required|same:password',
        // ]);

        // if($validator->fails()){
        //     return $this->sendError('Validation Error.', $validator->errors());
        // }

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
        if(Auth::attempt(['business_email' => $request->business_email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
           $userToken =  $success['token']['token'];
            $success['name'] =  $user->name;
            $success['id']  = $user->id;
            // return $this->sendResponse($success['name'], $userToken,'User login successfully.');

            $userID = $user->id;

            // get customer ID (bleyt) from haswallet table
            $customerID = DB::select( DB::raw("SELECT bleyt_id FROM haswallets WHERE userID = :userID"), array(
                'userID' => $userID,
              ));


            //   if (!(is_null($customerID))) {
            //     return $customerID = $customerID[0]->bleyt_id;
            // }
            if ($customerID == []) {
                 $customerID = 'null';
            }
            else{
                $customerID = $customerID[0]->bleyt_id;
            }

            //   $customerID = $customerID[0]->bleyt_id;

            return response()->json([
              'name' =>  $success['name'],
              'userID' => $success['id'] ,
               'userToken' =>  $userToken,
               'customerID' => $customerID,
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

    // public function getUserData(Request $request){
    //     return response()->json([
    //         'message'=> 'Welcome to Homepage'
    //     ], 201);
    // }
}
