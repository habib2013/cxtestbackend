<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Illuminate\Console\Command;

class AutoCreditWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autocredit:wallet';

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

        $payback= DB::select( DB::raw("SELECT * FROM savings WHERE payback_date = :payback_date"), array(
        'payback_date' => $mytime,
        ));
        // print_r($payback);

        if ($payback) {

            for ($i=0; $i < count($payback); $i++) {
                $paybackMail = $payback[$i]->userMail;

                $paybackAmount = (int)$payback[$i]->amount;

                $newAmount1 = 0;

                // $newAmount = $selectMail[0]->walletBalance;

                $newAmount1 += $paybackAmount;

                 print_r($newAmount1);
               
                $selectMail= DB::select( DB::raw("SELECT * FROM userwallets WHERE userMail = :userMail"), array(
                'userMail' => $paybackMail,
                ));


            }


        }


    }
}
