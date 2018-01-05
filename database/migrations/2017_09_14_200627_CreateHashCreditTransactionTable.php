<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHashCreditTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::create('hash_credit_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hashid');
            $table->integer('transactionidfrom');
            $table->string('transactiontablefrom');
            $table->string('accountreceivetype');
            $table->float('amount');
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
        Schema::dropIfExists('hash_credit_transactions');

    }
}
