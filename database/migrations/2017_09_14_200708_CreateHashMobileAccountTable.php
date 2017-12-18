<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashMobileAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::create('hash_mobile_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('companyname');
            $table->string('phonenumber');
            // $table->string('type');//if yes accounts used based on type
            $table->string('status');
            $table->integer('custom')->nullable();//enter number of star priority
            $table->string('client')->nullable();//enter client name
            $table->integer('hashid');            
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
        Schema::dropIfExists('hash_mobile_accounts');

    }
}
