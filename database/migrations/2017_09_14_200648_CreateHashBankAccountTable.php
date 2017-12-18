<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::create('hash_bank_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bankname');
            $table->string('accountnumber');
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
        Schema::dropIfExists('hash_bank_accounts');

    }
}
