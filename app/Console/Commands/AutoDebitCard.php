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

class AutoDebitCard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autodebit:card';

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
// *****auto debit in respect to the amount in table ****
// check if the

        $mytime = Carbon::now()->toDateString();

        $howoften = 'Daily';
        $howoftenWeekly = 'Weekly';
        $howoftenMonthly = 'Monthly';

        $howoftenResult= DB::select( DB::raw("SELECT * FROM savings WHERE howoften = :howoften"), array(
        'howoften' => $howoften,
        ));
        $howoftenResultWeekly= DB::select( DB::raw("SELECT * FROM savings WHERE howoften = :howoften"), array(
            'howoften' => $howoftenWeekly,
            ));

        if ($howoftenResult) {
            for($i = 0;$i < count($howoftenResult);$i++){
                $mydec =  $howoftenResult[$i]->created_at;
                $interest = $howoftenResult[$i]->interest;
                $payback_date = $howoftenResult[$i]->payback_date;
                $amount = $howoftenResult[$i]->amount;
                $title = $howoftenResult[$i]->title;
                $mymail = $howoftenResult[$i]->userMail;
                $calculatedBenefits = $howoftenResult[$i]->calculatedBenefits;

                $userAuth= DB::select( DB::raw("SELECT * FROM cardauths WHERE email = :email"), array(
                    'email' => $mymail,
                    ));

print_r($userAuth);

   $response =    Http::withHeaders([
                    'Content-type' => 'application/json',
                    'Authorization' =>
                    // 'Bearer sk_live_8c5c0e32507cb62ae4e237384dc2f5c8896b2330' // capital x live
                    // 'Bearer sk_test_f4d00fbdebcf31a02512634e379b0592d97050e6' - fillraphill test
                    'Bearer sk_test_0535a7f299f9f273c4a9a3b7fdbd888e50c5e4f8' // capital x test
                ])->post('https://api.paystack.co/transaction/charge_authorization', [

                    "authorization_code" => $userAuth[0]->authorization_code,
                     "email" => $mymail,
                     "amount" => 3000
                ]);
                $bodies = json_decode($response->body());

                print_r($bodies);
                if ($bodies) {
                    $newresponse =    Http::withHeaders([
                        'Content-type' => 'application/json',
                        'Accept' => 'application/json',
                        // 'Authorization' => 'Bearer $token'
                    ])->post('http://192.168.137.1:8000/api/savingsVault', [
                        'interest' => $interest,
                        'payback_date' => $payback_date,
                        'amount' => $amount,
                        'title' => $title,
                        'source' => 'from saved card / Auto debit',
                        'userMail' => $mymail,
                        'calculatedBenefits'=> $calculatedBenefits,
                        'howoften' => 'Daily',



                    ]);
                    $newbodies = json_decode($newresponse->body());

                    print_r($newbodies);

                }


            }
        }
         if($howoftenResultWeekly){

            for($i = 0;$i <= count($howoftenResultWeekly) -2 ;$i++){
                $mydec =  $howoftenResult[$i]->created_at;
               $resub =  substr($mydec, 0, 10);
            $daysToAdd = 7;
         $ucarb =   Carbon::createFromFormat('Y-m-d', $resub)->addDays($daysToAdd);
         $carbToString = $ucarb->toDateString();
         $mytime = Carbon::now()->toDateString();

         if ( $mytime == $carbToString) {
             print_r('they are equaal');
             # code...
         } else {
            print_r('they are not equaal');
         }


            }

        }

            //  print_r($payback);

    }
}
