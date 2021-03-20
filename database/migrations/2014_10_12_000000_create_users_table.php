<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_name');
            $table->string('business_email')->unique();
            $table->string('password');
            $table->string('office_address');
            $table->string('office_mobile');
            $table->string('account_holder');
            $table->string('account_number');
            $table->string('bank_name');
            $table->string('contact_person');
            $table->string('contact_mobile');
            $table->string('residential_address');
            $table->string('contact_email');
            $table->string('designation');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
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
        Schema::dropIfExists('users');
    }
}
