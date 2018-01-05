<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMobileAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_mobile_accounts', function (Blueprint $table) {
            // later shift priority based usage to users table
            $table->increments('id');
            $table->string('companyname');
            $table->string('phonenumber');
            $table->string('pin')->nullable();
            // $table->string('type');//if yes accounts used based on type
            $table->string('status');
            $table->integer('custom')->default(1)->nullable();//enter number of star priority
            $table->string('client')->nullable();//enter client name
            $table->integer('userid');            
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
        //
        Schema::dropIfExists('user_mobile_accounts');
    }
}
