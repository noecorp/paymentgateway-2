<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HashMobileAccount extends Model
{
    //
    protected $table='hash_mobile_accounts';

    public function hash(){
        return $this->belongsTo('App\Hash','hashid');

    }
}
