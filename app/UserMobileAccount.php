<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMobileAccount extends Model
{
    //
    	protected $table='user_mobile_accounts';

    public function users(){
        return $this->belongsTo('App\User','userid');

    }
}
