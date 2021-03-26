<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserwalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userwallets', function (Blueprint $table) {
            $table->id();
               $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile');
            $table->string('dob');
            $table->string('bvn')->unique();
            $table->string('userMail')->unique();
            $table->double('walletBalance', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userwallets');
    }
}
