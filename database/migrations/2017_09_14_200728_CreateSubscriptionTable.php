<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->integer('customerid');
            $table->integer('frequency');
            $table->string('status');
            $table->dateTime('nextpayment');
            $table->dateTime('previoustime');
            $table->integer('chargeattempts')->nullable();
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
        Schema::dropIfExists('subscriptions');

    }
}
