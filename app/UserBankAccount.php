<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    //
	protected $table='user_bank_accounts';

    public function users(){
        return $this->belongsTo('App\User','userid');

    }
}
