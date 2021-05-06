<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CreditWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:wallet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mytime = Carbon::now()->toDateString(); 
        print_r('today date');
        print_r($mytime);

        $paybackDate= DB::select( DB::raw("SELECT * FROM savings WHERE payback_date = :mytime"), array(
            'mytime' => $mytime,
            ));

           
            
            //check back here
            // print_r($paybackDate);
            // $payMeback = $paybackDate[1]->payback_date;
            // print_r('payback date');
            // print_r($payMeback);

            for ($i=0; $i < count($paybackDate); $i++) { 
            $userEmail = $paybackDate[$i]->userMail;
            $userAmount = $paybackDate[$i]->amount;
            $userInterest = $paybackDate[$i]->interest;
            $userPayback = $paybackDate[$i]->payback_date;

           
            }
                print_r($userEmail);
            if ($mytime == $userPayback) {
                print_r('they are equal');
                $getUserWallet= DB::select( DB::raw("SELECT * FROM userwallets WHERE userMail = :userMail"), array(
                    'userMail' => $userEmail,
                    ));


                    for ($i=0; $i < count($getUserWallet); $i++) { 
                        print_r($getUserWallet[$i]->walletBalance);
                  $userWalletBalance = $getUserWallet[$i]->walletBalance;
                  
                  $userInterest = $userAmount * ($userInterest/100);

                  $newUserBalance = $userAmount + $userWalletBalance + $userInterest;
                                  
                  print_r('new user wallet');
                  print_r($newUserBalance);

                  $newresponse =    Http::withHeaders([
                    'Content-type' => 'application/json',
                    'Accept' => 'application/json',
                    // 'Authorization' => 'Bearer $token'
                ])->post(' http://192.168.43.57:8000/api/updateUserWallet', [
                    'id' => $interest,
                    'first_name' => $payback_date,
                    'last_name' => $amount,
                    'mobile' => $title,
                    'dob' => 'from saved card / Auto debit',
                    'bvn' => $mymail,
                    'userMail'=> $calculatedBenefits,
                    'walletBalance' => 'Weekly',
                    'created_at' => $newUserBalance

                ]);
                $newbodies = json_decode($newresponse->body());

                print_r($newbodies);

                    }

                  

             } else {
                 print_r('they are not');
             }

     
        
    }
}
