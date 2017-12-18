<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDebitTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        //
        Schema::create('user_debit_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customerid');
            $table->integer('payeraccountid');
            $table->string('description');
            $table->string('accountpaytype');
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
        Schema::dropIfExists('user_debit_transactions');

    }
}
