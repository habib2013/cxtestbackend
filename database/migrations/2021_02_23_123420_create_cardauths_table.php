<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardauthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cardauths', function (Blueprint $table) {

            $table->id();
            $table->string('email');
            $table->string('authorization_code');
            $table->string('card_type');
            $table->string('last4');
            $table->string('exp_month');

            $table->string('exp_year');
            $table->string('bin');
            $table->string('bank');
            $table->string('channel');

            $table->string('signature');
            $table->string('reusable');
            $table->string('country_code');
            $table->string('account_name');
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
        Schema::dropIfExists('cardauths');
    }
}
