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
//chosen date you want to the system to autodebit your card
    $mytime = Carbon::now()->toDateString();

    $payback= DB::select( DB::raw("SELECT * FROM savings WHERE payback_date = :payback_date"), array(
    'payback_date' => $mytime,
    ));


        // print_r($payback);

        if ($payback) {

         $response =    Http::withHeaders([
                'Content-type' => 'application/json',
                'Authorization' =>
                // 'Bearer sk_live_8c5c0e32507cb62ae4e237384dc2f5c8896b2330' // capital x live
                // 'Bearer sk_test_f4d00fbdebcf31a02512634e379b0592d97050e6' - fillraphill test
                'Bearer sk_test_0535a7f299f9f273c4a9a3b7fdbd888e50c5e4f8' // capital x test
            ])->post('https://api.paystack.co/transaction/charge_authorization', [
                // 'name' => 'Taylor',
                // 'role' => 'Developer',
                "authorization_code" => 'AUTH_6xm6ry0ol0',
                 "email" => 'mail@ajs.com',
                 "amount" => 3000
            ]);
            $bodies = json_decode($response->body());

            print_r($bodies);

                if ($bodies) {
                    $newresponse =    Http::withHeaders([
                        'Content-type' => 'application/json',
                        'Accept' => 'application/json',
                        // 'Authorization' => 'Bearer $token'
                    ])->post('http://127.0.0.1:8000/api/savingsVault', [
                        'interest' => '10%',
                        'payback_date' => '2021/12/22',
                        'amount' => '500',
                        'title' => 'this is title',
                        'source' => 'from saved card',
                        'userMail' => 'mail@ajs.com',

                    ]);
                    $newbodies = json_decode($newresponse->body());

                    print_r($newbodies);

                }


        }

        // print_r($result);


        // $this->info('Error returned');
    }
}
