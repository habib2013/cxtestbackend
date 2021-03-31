<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Haswallet;
use Illuminate\Support\Facades\Auth;
use Validator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
           $userToken =  $success['token']['token'];
            $success['merchant_name'] =  $user->name;
            $success['id']  = $user->id;

            $userID = $user->id;

            // return redirect()->route('userdashboard');
            return redirect('dashboard')->with('status', 'Registeration successful!');

        }
        else{
            return response()->json([
                'Username or password Incorrect',

                  'message' => 'User login Failed!!.'
              ], 404);
        }
    }


}
