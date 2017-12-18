<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCreditTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::create('user_credit_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customerid');
            $table->integer('receiveaccountid');
            $table->string('description');
            $table->string('accountreceivetype');
            $table->float('amount');
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
        Schema::dropIfExists('user_credit_transactions');

    }
}
