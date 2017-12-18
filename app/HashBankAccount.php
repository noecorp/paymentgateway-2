<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HashBankAccount extends Model
{
    //
	protected $table='hash_bank_accounts';
    public function hash(){
        return $this->belongsTo('App\Hash','hashid');

    }

}
