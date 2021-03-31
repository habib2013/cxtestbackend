<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Userwallet;
use App\Models\Savings;
use App\Models\Benefits;
class UserdashboardController extends Controller
{
   public function dashboard(){
        $uWallet = Userwallet::all();
        $savings = Savings::all();
        $benefit = Benefits::all();

       return view('userdashboard',compact('uWallet','savings','benefit'));
   }


   public function savings(){
    $savings = Savings::all();

   return view('savings',compact('savings'));
}

public function benefits(){

    return view('benefits');
 }
}
