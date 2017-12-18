<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemporaryRequestVerifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
        //
        Schema::create('request_verify', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clientid');
            $table->string('otprequestid');
            $table->string('phonenumber');
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
        Schema::dropIfExists('request_verify');

    }
}
